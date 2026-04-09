<?php

namespace App\Repository\Dashboard\Traits;

use App\Exception\RepositoryException;

trait CanPublished
{
    /**
     * @throws RepositoryException
     */
    public function published(string $table, array $data): void
    {
        try {
            $this->runQuery("UPDATE $table SET status = :published WHERE id = :id", [
                ':published' => $data['published'],
                ':id' => $data['id'],
            ]);
        }catch(RepositoryException $e) {
            throw new RepositoryException('Nie udało się zmienić statusu', 500, $e);
        }
    }
}