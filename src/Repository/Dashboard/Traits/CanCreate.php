<?php

namespace App\Repository\Dashboard\Traits;

use App\DTO\DataTransferObjectInterface;
use App\Exception\RepositoryException;
use Exception;
use PDOStatement;

/**
 * @method PDOStatement runQuery(string $sql, array $params = [])
 */
trait CanCreate
{
    /**
     * @throws RepositoryException
     */
    public function create(string $table, DataTransferObjectInterface $data): void
    {
        try {
            $payload = $data->toArray();

            unset($payload['id']);

            $columns = implode(", ", array_keys($payload));
            $placeholders = implode(", ", array_map(fn($key) => ":$key", array_keys($payload)));

            $bindings = [];
            foreach ($payload as $key => $value) {
                $bindings[":$key"] = $value;
            }

            $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

            $this->runQuery($sql, $bindings);
        } catch (Exception $e) {
            throw new RepositoryException("Failed to create record", 500, $e);
        }
    }
}