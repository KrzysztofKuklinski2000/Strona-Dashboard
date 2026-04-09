<?php

namespace App\Repository\Dashboard\Traits;

use App\Exception\RepositoryException;
use PDOStatement;

/**
 * @method PDOStatement runQuery(string $sql, array $params = [])
 */
trait CanDelete
{
    /**
     * @throws RepositoryException
     */
    public function delete(string $table, int $id): void
    {
        try {
            $this->runQuery("DELETE FROM $table WHERE id = :id", [":id" => $id]);
        } catch (RepositoryException $e) {
            throw new RepositoryException('Nie udało się usunąć posta', 500, $e);
        }
    }
}