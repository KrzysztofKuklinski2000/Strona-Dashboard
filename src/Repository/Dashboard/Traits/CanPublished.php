<?php

namespace App\Repository\Dashboard\Traits;

use App\DTO\DataTransferObjectInterface;
use App\Exception\RepositoryException;

trait CanPublished
{
    /**
     * @throws RepositoryException
     */
    public function published(string $table, DataTransferObjectInterface $data): void
    {
        try {
            $this->runQuery("UPDATE $table SET status = :published WHERE id = :id", [
                ':published' => $data->toArray()['published'],
                ':id' => $data->toArray()['id'],
            ]);
        }catch(RepositoryException $e) {
            throw new RepositoryException('Nie udało się zmienić statusu', 500, $e);
        }
    }
}