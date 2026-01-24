<?php

namespace Tests\Core;

use PDO;
use App\Core\Database;
use PHPUnit\Framework\TestCase;
use App\Exception\RepositoryException;

class DatabaseConnectionTest extends TestCase
{
  public function testShouldThrowRepositoryExceptionWhenConnectionFails(): void
  {
    // GIVEN
    $config = [
      'database' => 'not_existing_db',
      'host' => 'invalid_host',
      'user' => 'user',
      'password' => 'pass'
    ];

    $database = new Database($config);

    // EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Błąd połączenia z bazą danych !');

    // WHEN
    $database->connect();
  }

  public function testShouldReturnPdoObjectWhenCredentialsAreValid(): void
  {
    // GIVEN
    $config =  [
      'host' => 'localhost',
      'database' => 'karate',
      'user' => 'user_karate',
      'password' => 'Qwerty1@3'
    ];

    $database = new Database($config);

    // WHEN
    $pdo = $database->connect();

    // THEN
    $this->assertInstanceOf(PDO::class, $pdo);
  }
}
