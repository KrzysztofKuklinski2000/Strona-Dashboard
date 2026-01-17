<?php

namespace App\Core;

use PDO;
use PDOException;
use App\Exception\RepositoryException;

class Database {
  public function __construct(private array $config){}

  public function connect(): PDO {
    try {
      $dns = "mysql:dbname={$this->config['database']};host={$this->config['host']}";
      
      $pdo = new PDO($dns, $this->config['user'], $this->config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_PERSISTENT => false,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      ]);

      return $pdo;
    } catch (PDOException $e) {
      throw new RepositoryException('Błąd połączenia z bazą danych !', 500, $e);
    }
  }
}