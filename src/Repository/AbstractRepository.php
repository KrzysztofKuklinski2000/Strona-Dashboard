<?php

declare(strict_types=1);

namespace App\Repository;

use App\Exception\RepositoryException;
use PDO;
use PDOException;
use PDOStatement;


class AbstractRepository {
  public function __construct(protected PDO $con) {}

  public function runQuery(string $sql, array $params = []): PDOStatement
  {
    try {
      $stmt = $this->con->prepare($sql);
      foreach ($params as $key => $value) {
        if (is_array($value)) {
          $stmt->bindValue($key, $value[0], $value[1]);
        } else {
          $stmt->bindValue($key, $value, PDO::PARAM_STR);
        }
      }
      $stmt->execute();
      return $stmt;
    } catch (PDOException $e) {
      throw new RepositoryException("Błąd bazy danych", 500, $e);
    }
  }

  public function beginTransaction(): bool {
    return $this->con->beginTransaction();
  }

  public function commit(): bool {
    return $this->con->commit();
  }
  public function rollback(): bool {
    if ($this->con->inTransaction()) {
      return $this->con->rollback();
    }
    return false;
  }
}