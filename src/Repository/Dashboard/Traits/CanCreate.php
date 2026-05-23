<?php

namespace App\Repository\Dashboard\Traits;

use App\DTO\DataTransferObjectInterface;
use App\Exception\RepositoryException;
use PDOStatement;

/**
 * @method PDOStatement runQuery(string $sql, array $params = [])
 */
trait CanCreate
{
    /**
     * @throws RepositoryException
     */
    public function create(string $table, DataTransferObjectInterface $data ): void {
        try {
            $arrayData = $data->toArray();
            $col = implode(", ", array_map(fn($k) => "$k", array_filter(array_keys($arrayData), fn($k) => $k !== "id")));
            $val = implode(", ", array_map(fn($k) => ":$k", array_filter(array_keys($arrayData), fn($k) => $k !== "id")));
            $result = array_combine(array_map(fn($k) => ":$k", array_keys($arrayData)), $arrayData);

            $sql = "INSERT INTO $table ($col) VALUES ($val)";

            $this->runQuery($sql,$result);
        }catch(RepositoryException $e) {
            throw new RepositoryException("Nie udało się utworzyć posta", 500, $e);
        }
    }
}