<?php

namespace App\Repository\Dashboard;

use App\DTO\Dashboard\SubscribersDto;
use App\Exception\NotFoundException;
use App\Exception\RepositoryException;
use App\Repository\Dashboard\Traits\StandardCrud;
use PDO;

class SubscriberRepository extends BaseDashboardRepository
{
    use StandardCrud;

    protected function mapToDto(array $data): SubscribersDto
    {
        return SubscribersDto::fromArray($data);
    }

    /**
     * @return SubscribersDto[]
     * @throws RepositoryException
     */
    public function getActiveEmails(): array
    {
        try {
            $stmt = $this->runQuery("SELECT * FROM subscribers WHERE is_active = 1");
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
            return array_map(fn(array $row) => $this->mapToDto($row), $result);
        } catch (RepositoryException $e) {
            throw new RepositoryException("Nie udało się pobrać subskrybentów", 500, $e);
        }
    }

    /**
     * @throws RepositoryException
     */
    public function emailExists(string $email): bool
    {
        try {
            $sql = "SELECT COUNT(*) FROM subscribers WHERE email = :email";
            $result = $this->runQuery($sql, [':email' => $email])->fetchColumn();

            return $result > 0;
        } catch (RepositoryException $e) {
            throw new RepositoryException('Nie udało się pobrać subskrybenta', 500, $e);
        }
    }

    /**
     * @throws NotFoundException
     * @throws RepositoryException
     */
    public function getSubscriberByToken(string $token): SubscribersDto
    {
        try {
            $result = $this->runQuery("SELECT * FROM subscribers WHERE token = :token", [':token' => $token])
                ->fetch(PDO::FETCH_ASSOC);
        } catch (RepositoryException $e) {
            throw new RepositoryException('Nie udało się pobrać subskrybenta', 500, $e);
        }

        if (!$result) {
            throw new NotFoundException('Nie ma takiego subskrybenta', 404);
        }

        return $this->mapToDto($result);
    }

    /**
     * @throws RepositoryException
     */
    public function deletePendingSubscriberByToken(string $token): void
    {
        try {
            $this->runQuery(
                'DELETE FROM subscribers WHERE token = :token AND is_active = 0',
                [':token' => $token]
            );
        } catch (RepositoryException $e) {
            throw new RepositoryException(
                'Nie udało się usunąć oczekującej subskrypcji',
                500,
                $e
            );
        }
    }
}