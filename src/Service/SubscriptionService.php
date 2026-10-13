<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Dashboard\Subscriber\CreateSubscriberDto;
use App\DTO\Dashboard\Subscriber\SubscribersDto;
use App\Exception\NotFoundException;
use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Notification\Notifier;
use App\Repository\Dashboard\SubscriberRepository;
use App\Security\TokenGeneratorInterface;
use App\Service\Contracts\SubscriptionServiceInterface;
use DateTimeImmutable;
use DateTimeZone;
use Random\RandomException;
use Throwable;

/**
 * Publiczny zapis, potwierdzenie i wypisanie z powiadomień.
 * Token potwierdzenia trafia do maila, a w bazie przechowujemy tylko jego hash.
 * Link jest ważny 24 godziny; ponowną próbę wysyłki dopuszczamy po 5 minutach.
 */
class SubscriptionService implements SubscriptionServiceInterface
{
    private const TABLE = 'subscribers';

    public function __construct(
        private readonly SubscriberRepository    $subscriberRepository,
        private readonly TokenGeneratorInterface $tokenGenerator,
        private readonly Notifier                $notifier,
    ) {
    }

    /**
     * Aktywuje oczekującą subskrypcję na podstawie tokenu otrzymanego z linku.
     * Repozytorium jednym UPDATE sprawdza ważność i zużywa token potwierdzenia.
     *
     * @throws NotFoundException
     * @throws ServiceException
     */
    public function confirm(string $token): void
    {
        try {
            // Hashujemy token z linku tak samo jak podczas zapisu; nie odtwarzamy go z bazy.
            $tokenHash = hash('sha256', $token);
            // Osobny token służy wyłącznie do wypisania i trafia do kolejnych powiadomień.
            $unsubscribeToken = $this->tokenGenerator->generate();

            $confirmed = $this->subscriberRepository->confirmPendingSubscription($tokenHash, $unsubscribeToken);

            if(!$confirmed) {
                // Brak zmiany oznacza m.in. token błędny, wygasły lub już wykorzystany.
                throw new NotFoundException(
                    'Link potwierdzający jest nieprawidłowy lub wygasł.',
                    404
                );
            }
        } catch (RepositoryException|RandomException $e) {
            throw new ServiceException(
                'Nie udało się potwierdzić subskrypcji.',
                500,
                $e,
            );
        }
    }

    /**
     * Usuwa subskrypcję wskazaną osobnym tokenem wypisania.
     * Nie przyjmuje tokenu potwierdzenia jako klucza do usuwania.
     *
     * @throws NotFoundException
     * @throws ServiceException
     */
    public function unsubscribe(string $token): void
    {
        try {
            $deleted = $this->subscriberRepository->deleteActiveSubscriptionByToken($token);

            if (!$deleted) {
                throw new NotFoundException(
                    'Link wypisania jest nieprawidłowy lub został już wykorzystany.',
                    404,
                );
            }
        } catch (RepositoryException $e) {
            throw new ServiceException(
                'Nie udało się usunąć subskrypcji.',
                500,
                $e,
            );
        }
    }

    /**
     * Tworzy oczekującą subskrypcję albo odnawia jej link potwierdzający.
     * Zwykłe zakończenie nie oznacza zawsze wysłania maila: aktywny adres,
     * odstęp krótszy niż 5 minut i równoczesny zapis nie powodują nowej wysyłki.
     *
     * @throws ServiceException
     */
    public function subscribe(CreateSubscriberDto $data): void
    {
        try {
            // To odczyt bieżącego stanu, nie rezerwacja adresu ani blokada innych żądań.
            $subscriber = $this->subscriberRepository->getSubscriberByEmail($data->email);

            if($subscriber !== null && $subscriber->isActive === 1) {
                // Nie wysyłamy kolejnego potwierdzenia do już aktywnego subskrybenta.
                return;
            }

            $token = $this->tokenGenerator->generate();
            // Oryginał wykorzystamy w mailu; sam hash nie jest kluczem wysyłanym użytkownikowi.
            $tokenHash = hash('sha256', $token);

            // Daty zapisujemy w UTC, zgodnie z UTC_TIMESTAMP() używanym w repozytorium.
            $now  = new DateTimeImmutable('now', new DateTimeZone('UTC'));
            $expiresAt = $now->modify('+24 hours');

            $saveDto = SubscribersDto::fromArray([
                'id' => 0,
                'email' => $data->email,
                'is_active' => 0,
                'confirmation_token_hash' => $tokenHash,
                'confirmation_expires_at' => $expiresAt->format('Y-m-d H:i:s'),
                'confirmation_last_sent_at' => $now->format('Y-m-d H:i:s'),
            ]);

            if ($subscriber === null) {
                // Inne żądanie mogło zapisać ten adres po naszym wcześniejszym SELECT.
                $created = $this->subscriberRepository->createPendingSubscription($saveDto);

                if (!$created) {
                    // Adres zdążył już zostać utworzony; nie wysyłamy drugiego maila.
                    return;
                }
            }else {
                // Warunek 5 minut i aktualizacja są w jednym zapytaniu, nie tylko w PHP.
                $renewed = $this->subscriberRepository->renewPendingSubscription($data->email, $tokenHash);

                if(!$renewed) {
                    // Za wcześnie na wysyłkę albo w międzyczasie zmienił się stan rekordu.
                    return;
                }
            }

        } catch (RepositoryException|RandomException $e) {
            throw new ServiceException(
                'Nie udało się utworzyć subskrypcji.',
                500,
                $e,
            );
        }

        try {
            // Wysyłamy dopiero po udanym zapisie nowego hashu w bazie.
            $this->notifier->sendConfirmationEmail($data->email, $token);
        } catch (Throwable $e) {
            // Nie kasujemy rekordu: pozostaje oczekujący, a kolejna próba jest możliwa po 5 minutach.
            // confirmation_last_sent_at opisuje próbę wysyłki, nie gwarantowane dostarczenie maila.
            throw new ServiceException(
                'Nie udało się wysłać wiadomości potwierdzającej.',
                500,
                $e,
            );
        }
    }

    /**
     * Sprawdza, czy link wskazuje aktywną subskrypcję.
     * Nie zmienia ani nie usuwa żadnych danych.
     *
     * @throws NotFoundException
     * @throws ServiceException
     */
    public function validateUnsubscribeToken(string $token): void {
        try {
            $this->subscriberRepository->getSubscriberByUnsubscribeToken($token);
        } catch (RepositoryException $e) {
            throw new ServiceException(
                'Nie udało się sprawdzić linku wypisania.',
                500,
                $e,
            );
        }
    }
}
