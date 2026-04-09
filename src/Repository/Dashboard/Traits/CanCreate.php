<?php

namespace App\Repository\Dashboard\Traits;

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
    public function create(string $table, array $data ): void {
        try {
            $col = implode(", ", array_map(fn($k) => "$k", array_filter(array_keys($data), fn($k) => $k !== "id")));
            $val = implode(", ", array_map(fn($k) => ":$k", array_filter(array_keys($data), fn($k) => $k !== "id")));
            $result = array_combine(array_map(fn($k) => ":$k", array_keys($data)), $data);

            $sql = "INSERT INTO $table ($col) VALUES ($val)";

            $this->runQuery($sql,$result);
        }catch(RepositoryException $e) {
            throw new RepositoryException("Nie udało się utworzyć posta", 500, $e);
        }
    }
}