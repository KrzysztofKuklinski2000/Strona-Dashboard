<?php

declare(strict_types=1);

namespace App\Model;

use PDO;
use Throwable;
use PDOException;
use PDOStatement;
use App\Exception\StorageException;


class AbstractModel {
  protected PDO $con;
  private const ALLOWED_TABLES = ['news', 'contact', 'fees', 'camp', 'user', 'timetable', 'important_posts', 'main_page_posts', 'gallery'];

  public function __construct(array $config)
  {
    try {
      $dns = "mysql:dbname={$config['database']};host={$config['host']}";
      $this->con = new PDO($dns, $config['user'], $config['password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    } catch (PDOException $e) {
      throw new StorageException('Connection Error');
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
    } catch (Throwable) {
      throw new StorageException("Błąd bazy danych");
    }
  }

  protected function validateTable(string $table): string
  {
    if (!in_array($table, self::ALLOWED_TABLES)) {
      throw new StorageException("Nie ma takiej tabeli");
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