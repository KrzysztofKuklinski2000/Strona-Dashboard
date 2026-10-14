<?php

declare(strict_types=1);

namespace App\Repository\Dashboard;

use App\DTO\Dashboard\Subscriber\SubscribersDto;
use App\Exception\NotFoundException;
use App\Exception\RepositoryException;
use App\Repository\Dashboard\Traits\StandardCrud;
use PDO;
use PDOException;

/**
 * Operacje na subskrybentach dla publicznego zapisu i zarządzania w dashboardzie.
 * Decyzję o wysłaniu maila podejmuje serwis na podstawie wyników tych operacji.
 */
class SubscriberRepository extends BaseDashboardRepository
{
    use StandardCrud;

    protected function mapToDto(array $data): SubscribersDto
    {
        return SubscribersDto::fromArray($data);
    }

    /**
     * Pobiera aktywnych odbiorców powiadomień, razem z ich tokenami wypisania.
     *
     * @return SubscribersDto[]
     * @throws RepositoryException
     */
    public function getActiveEmails(): array
    {
        try {
            $stmt = $this->runQuery("SELECT * FROM subscribers WHERE is_active = 1");
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
            return array_map(fn (array $row) => $this->mapToDto($row), $result);
        } catch (RepositoryException $e) {
            throw new RepositoryException("Nie udało się pobrać subskrybentów", 500, $e);
        }
    }

    /**
     * Pobiera aktywny rekord na podstawie tokenu wypisania, nie hashu potwierdzenia.
     *
     * @throws NotFoundException
     * @throws RepositoryException
     */
    public function getSubscriberByUnsubscribeToken(string $token): SubscribersDto
    {
        try {
            $sql = 'SELECT * FROM subscribers
                    WHERE unsubscribe_token = :token AND is_active = 1';

            $result = $this->runQuery($sql, [':token' => $token])->fetch(PDO::FETCH_ASSOC);
        } catch (RepositoryException $e) {
            throw new RepositoryException('Nie udało się pobrać subskrybenta', 500, $e);
        }

        if ($result === false) {
            throw new NotFoundException('Nie ma takiego subskrybenta', 404);
        }

        return $this->mapToDto($result);
    }

    /**
     * Usuwa rekord tylko przy zgodnym tokenie wypisania i aktywnym statusie.
     *
     * @return bool True po usunięciu; false, gdy nie znaleziono pasującego rekordu.
     * @throws RepositoryException
     */
    public function deleteActiveSubscriptionByToken(string $token): bool
    {
        try {
            $sql = "DELETE FROM subscribers
                      WHERE unsubscribe_token = :token
                      AND is_active = 1";

            $stmt = $this->runQuery($sql, [':token' => $token]);
        }catch (RepositoryException $e) {
            throw new RepositoryException('Nie udało się usunąć subskrybenta', 500, $e);
        }

        return $stmt->rowCount() === 1;
    }

    /**
     * Zwraca DTO istniejącego subskrybenta albo null, jeżeli adres nie istnieje.
     * Serwis rozróżnia aktywny i oczekujący rekord na podstawie isActive w DTO.
     * Wynik jest odczytem stanu w danej chwili i nie blokuje późniejszych zmian.
     *
     * @throws RepositoryException
     */
    public function getSubscriberByEmail(string $email): ?SubscribersDto {
        try {
            $result = $this->runQuery("SELECT * FROM subscribers WHERE email = :email",
                [':email' => $email]
            )->fetch(PDO::FETCH_ASSOC);
        }catch (RepositoryException $e) {
            throw new RepositoryException('Nie udało się pobrać subskrybenta', 500, $e);
        }

        return $result === false ? null : $this->mapToDto($result);
    }

    /**
     * Jednym UPDATE aktywuje tylko nieaktywny rekord z pasującym, niewygasłym hashem.
     * Wyczyszczenie hashu i terminu ważności uniemożliwia ponowne użycie linku.
     * Osobny token wypisania pozostaje dostępny do generowania kolejnych maili.
     *
     * @return bool True po aktywacji; false, gdy żaden rekord nie spełnia warunków.
     * @throws RepositoryException
     */
    public function confirmPendingSubscription(string $tokenHash, string $unsubscribeToken): bool {
        try {

            $sql = 'UPDATE subscribers
                    SET is_active = 1,
                         confirmed_at = UTC_TIMESTAMP(),
                         confirmation_token_hash = NULL,
                         confirmation_expires_at = NULL,
                         unsubscribe_token = :unsubscribe_token
                   WHERE confirmation_token_hash = :token_hash
                     AND is_active = 0
                     AND confirmation_expires_at > UTC_TIMESTAMP()';

            $stmt = $this->runQuery($sql,
                [
                    ':token_hash' => $tokenHash,
                    ':unsubscribe_token' => $unsubscribeToken
                ]
            );

        }catch (RepositoryException $e) {
            throw new RepositoryException('Coś poszło nie tak', 500, $e);
        }

        return $stmt->rowCount() === 1;
    }

    /**
     * Odnawia potwierdzenie tylko dla nieaktywnego adresu po co najmniej 5 minutach.
     * Sprawdzenie odstępu i zapis nowego hashu odbywają się w jednym UPDATE,
     * aby równoczesne żądania nie dostały obydwa zgody na ponowną wysyłkę.
     * Zmiana hashu unieważnia poprzedni link i rozpoczyna nowe 24 godziny ważności.
     *
     * @return bool True po odnowieniu; false oznacza, że nie należy wysyłać maila.
     * @throws RepositoryException
     */
    public function renewPendingSubscription(
        string $email,
        string $tokenHash,
    ): bool {
        try {
            $sql = 'UPDATE subscribers
                SET confirmation_token_hash = :token_hash,
                    confirmation_expires_at =
                        DATE_ADD(UTC_TIMESTAMP(), INTERVAL 24 HOUR),
                    confirmation_last_sent_at = UTC_TIMESTAMP()
                WHERE email = :email
                  AND is_active = 0
                  AND (
                      confirmation_last_sent_at IS NULL
                      OR confirmation_last_sent_at <=
                          DATE_SUB(UTC_TIMESTAMP(), INTERVAL 5 MINUTE)
                  )';

            $stmt = $this->runQuery($sql, [
                ':email' => $email,
                ':token_hash' => $tokenHash,
            ]);
        } catch (RepositoryException $e) {
            throw new RepositoryException(
                'Nie udało się odnowić potwierdzenia subskrypcji.',
                500,
                $e,
            );
        }

        return $stmt->rowCount() === 1;
    }

    /**
     * Tworzy rekord przygotowany przez serwis i obsługuje konflikt równoczesnego zapisu.
     * Dwa żądania mogą wcześniej odczytać null dla tego samego adresu, ale indeks UNIQUE
     * pozwoli zapisać tylko jeden rekord. Drugi zapis nie powinien kończyć się błędem publicznym.
     *
     * @return bool True po utworzeniu; false, gdy adres już istnieje po konflikcie zapisu.
     * @throws RepositoryException
     */
    public function createPendingSubscription(SubscribersDto $data): bool
    {
        try {
            $this->create('subscribers', $data);

            return true;
        } catch (RepositoryException $e) {
            $cause = $e;

            // create() i runQuery() opakowują wyjątki; docieramy do oryginalnego błędu PDO.
            while ($cause->getPrevious() !== null) {
                $cause = $cause->getPrevious();
            }

            // 1062 to konflikt unikalności w MySQL. Potwierdzamy także istnienie tego emaila,
            // żeby nie uznać innego konfliktu lub awarii bazy za udany równoczesny zapis.
            if (
                $cause instanceof PDOException
                && (int) ($cause->errorInfo[1] ?? 0) === 1062
                && $this->getSubscriberByEmail($data->email) !== null
            ) {
                return false;
            }

            throw new RepositoryException(
                'Nie udało się utworzyć oczekującej subskrypcji.',
                500,
                $e,
            );
        }
    }
}
