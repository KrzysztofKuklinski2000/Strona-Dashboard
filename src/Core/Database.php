<?php

namespace App\Core;

use PDO;
use PDOException;
use App\Exception\RepositoryException;

class Database {
  public function __construct(private array $config){}

  public function connect(): PDO {
    try {
      $dsn = "mysql:dbname={$this->config['database']};host={$this->config['host']}";

      return $this->createConnection($dsn, $this->config['user'], $this->config['password']);
    } catch (PDOException $e) {
      throw new RepositoryException('Błąd połączenia z bazą danych !', 500, $e);
    }
  }

  protected function createConnection(string $dsn, string $user, string $password): PDO {
    return new PDO($dsn, $user, $password, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_PERSISTENT => false,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
  }
}