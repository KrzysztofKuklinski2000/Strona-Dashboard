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
    public function edit(string $table, DataTransferObjectInterface $data): void {
        try {
            $arrayData = $data->toArray();
            $sql = "UPDATE $table SET ". implode(", ", array_map(fn($k) => "$k = :$k", array_filter(array_keys($arrayData), fn($k)=> $k !== "id")));

            if(in_array($table, ['news', 'main_page_posts', 'important_posts', 'timetable', 'gallery', 'subscribers'])) $sql .= " WHERE id = :id";
            $result = array_combine(array_map(fn($k) => ":$k", array_keys($arrayData)), $arrayData);

            $this->runQuery($sql, $result);
        }catch(RepositoryException $e) {
            throw new RepositoryException("Nie udało się edytować posta", 500, $e);
        }
    }
}