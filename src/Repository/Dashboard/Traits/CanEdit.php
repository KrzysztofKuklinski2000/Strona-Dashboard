<?php

namespace App\Repository\Dashboard\Traits;

use App\DTO\DataTransferObjectInterface;
use App\Exception\RepositoryException;
use PDOStatement;

/**
 * @method PDOStatement runQuery(string $sql, array $params = [])
 */
trait CanEdit
{
    /**
     * @throws RepositoryException
     */
    public function edit(string $table, DataTransferObjectInterface $data): void
    {
        try {
            $payload = $data->toArray();

            $hasId = array_key_exists('id', $payload);

            $updateFields = $payload;
            unset($updateFields['id']);

            $setClause = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($updateFields)));
            $sql = "UPDATE $table SET $setClause";

            if ($hasId) {
                $sql .= " WHERE id = :id";
            }

            $bindings = [];
            foreach ($payload as $key => $value) {
                $bindings[":$key"] = $value;
            }

            $this->runQuery($sql, $bindings);
        } catch (RepositoryException $e) {
            throw new RepositoryException("Failed to edit record", 500, $e);
        }
    }
}