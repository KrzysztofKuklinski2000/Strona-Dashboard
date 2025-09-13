<?php

declare(strict_types=1);

namespace App\Repository;

use PDO;
use Throwable;
use PDOException;
use PDOStatement;
use App\Exception\StorageException;


class AbstractRepository {
  public PDO $con;
  private const ALLOWED_TABLES = ['news', 'contact', 'fees', 'camp', 'user', 'timetable', 'important_posts', 'main_page_posts', 'gallery'];

  public function __construct(array $config)
  {
    try {
      $dns = "mysql:dbname={$config['database']};host={$config['host']}";
      $this->con = new PDO($dns, $config['user'], $config['password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    } catch (PDOException $e) {
      throw StorageException::databaseConnection(
        "Host: {$config['host']}, Database: {$config['database']}", 
        $e
      );
    }
  }

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
    } catch (Throwable $e) {
      throw StorageException::queryFailed(
        "SQL execution", 
        $e, 
        ['sql' => $sql, 'params' => $params]
      );
    }
  }

  protected function validateTable(string $table): string
  {
    if (!in_array($table, self::ALLOWED_TABLES)) {
      throw StorageException::queryFailed(
        "Table validation", 
        null, 
        ['table' => $table, 'allowed_tables' => self::ALLOWED_TABLES]
      );
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
    } catch (Throwable $e) {
      throw new StorageException('Nie udało się załadować zawartości strony.', 400, $e);
    }
  }
}