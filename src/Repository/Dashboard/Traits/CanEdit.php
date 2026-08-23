<?php

declare(strict_types=1);

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

            if (!array_key_exists('id', $payload)) {
                throw new RepositoryException('Brak identyfikatora edytowanego rekordu.');
            }

            $updateFields = $payload;
            unset($updateFields['id']);

            $setClause = implode(", ", array_map(fn ($key) => "$key = :$key", array_keys($updateFields)));
            $sql = "UPDATE $table SET $setClause WHERE id = :id";

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
