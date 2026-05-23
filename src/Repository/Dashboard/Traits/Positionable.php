<?php

namespace App\Repository\Dashboard\Traits;

use App\DTO\DataTransferObjectInterface;
use App\Exception\RepositoryException;
use PDO;
use PDOStatement;

trait Positionable {
    /**
     * @throws RepositoryException
     */
    public function movePosition(string $table, int $id, int $position): PDOStatement {
        try {
            return $this->runQuery("UPDATE $table SET position = :pos WHERE id = :id", [
                ':pos' => $position,
                ':id' => $id
            ]);
        }catch (RepositoryException $e) {
            throw new RepositoryException("Nie udało się zmienić pozycji", 500, $e);
        }
    }

    /**
     * @throws RepositoryException
     */
    public function getPostByPosition(string $table, int $position): ?DataTransferObjectInterface {
        try{
            $result = $this->runQuery("SELECT * FROM $table WHERE position = :pos", [':pos' => $position])->fetch(PDO::FETCH_ASSOC);
            return $result ? $this->mapToDto($result) : null;
        }catch(RepositoryException $e) {
            throw new RepositoryException("Nie udało się pobrać elementu", 500, $e);
        }
    }

    /**
     * @throws RepositoryException
     */
    public function incrementPosition(string $table):void {
        try{
            $this->runQuery("UPDATE $table SET position = position + 1");
        }catch(RepositoryException $e) {
            throw new RepositoryException("Nie udało się zmienić pozycji", 500, $e);
        }
    }

    /**
     * @throws RepositoryException
     */
    public function decrementPosition(string $table, int $position) :void {
        try {
            $this->runQuery("UPDATE $table set position = position - 1 WHERE position > :pos", [':pos' => $position]);
        }catch(RepositoryException $e) {
            throw new RepositoryException('Nie udało się zmienić pozycji', 500, $e);
        }
    }
}