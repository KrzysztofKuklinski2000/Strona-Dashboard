<?php

declare(strict_types=1);

namespace App\Repository;

use App\Exception\RepositoryException;
use PDO;
use PDOException;
use PDOStatement;


class AbstractRepository {
  private const ALLOWED_TABLES = ['news', 'contact', 'fees', 'camp', 'user', 'timetable', 'important_posts', 'main_page_posts', 'gallery'];

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



  protected function validateTable(string $table): string
  {
    if (!in_array($table, self::ALLOWED_TABLES)) {
      throw new RepositoryException("Nie ma takiej tabeli", 400);
    }

    return $table;
  }

  public function timetablePageData(): array
  {
    try {
      $sql = "
				SELECT * FROM timetable ORDER BY 
					CASE 
						WHEN day = 'PON' THEN 1
						WHEN day = 'WT' THEN 2
						WHEN day = 'ŚR' THEN 3
						WHEN day = 'CZW' THEN 4
						WHEN day = 'PT' THEN 5
						WHEN day = 'SOB' THEN 6
					END ASC, start ASC";

      return $this->runQuery($sql)->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new RepositoryException('Nie udało się pobrać danych.', 500, $e);
    }
  }
}