<?php

namespace App\Repository\Dashboard\Traits;

use App\Exception\RepositoryException;
use PDOStatement;

/**
 * @method PDOStatement runQuery(string $sql, array $params = [])
 */
trait CanEdit
{
    /**
     * @throws RepositoryException
     *
     */
    public function edit(string $table, array $data):void {
        try {
            $sql = "UPDATE $table SET ". implode(", ", array_map(fn($k) => "$k = :$k", array_filter(array_keys($data), fn($k)=> $k !== "id")));

            if(in_array($table, ['news', 'main_page_posts', 'important_posts', 'timetable', 'gallery', 'subscribers'])) $sql .= " WHERE id = :id";
            $result = array_combine(array_map(fn($k) => ":$k", array_keys($data)), $data);

            $this->runQuery($sql, $result);
        }catch(RepositoryException $e) {
            throw new RepositoryException("Nie udało się edytować posta", 500, $e);
        }
    }
}