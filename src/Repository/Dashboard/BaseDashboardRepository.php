<?php

namespace App\Repository\Dashboard;

use App\DTO\DataTransferObjectInterface;
use App\Exception\NotFoundException;
use App\Exception\RepositoryException;
use App\Repository\AbstractRepository;
use PDO;

abstract class BaseDashboardRepository extends AbstractRepository {

    abstract protected function mapToDto(array $data): DataTransferObjectInterface;

    /**
     * @return DataTransferObjectInterface[]
     * @throws RepositoryException
     */
    public function getDashboardData(string $table, string $orderBy = 'position'): array
    {
        try {
            $sql = "SELECT * FROM $table ORDER BY $orderBy ASC";
            $result = $this->runQuery($sql)->fetchAll(PDO::FETCH_ASSOC);

            return array_map(fn(array $row) => $this->mapToDto($row), $result);
        }catch(RepositoryException $e) {
            throw new RepositoryException("Nie udało się pobrać danych", 500, $e);
        }
    }

    /**
     * @throws RepositoryException
     * @throws NotFoundException
     */
    public function getPost(string $table, int $id): DataTransferObjectInterface {
        try {
            $result = $this->runQuery("SELECT * FROM $table WHERE id = :id", [':id' => $id])->fetch(PDO::FETCH_ASSOC);
        } catch (RepositoryException $e) {
            throw new RepositoryException('Nie udało się pobrać posta', 500, $e);
        }

        if(!$result) {
            throw new NotFoundException('Nie ma takiego posta', 404);
        }

        return $this->mapToDto($result);
    }
}