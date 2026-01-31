<?php

namespace Tests\Core;

use PDO;
use App\Core\Database;
use PHPUnit\Framework\TestCase;
use App\Exception\RepositoryException;
use PDOException;

class DatabaseTest extends TestCase {
  public function testShouldThrowRepositoryExceptionWhenConnectionFails(): void
  {
    // GIVEN
    $config = [
      'database' => 'not_existing_db',
      'host' => 'invalid_host',
      'user' => 'user',
      'password' => 'pass'
    ];

    $database = $this->getMockBuilder(Database::class)
      ->setConstructorArgs([$config])
      ->onlyMethods(['createConnection'])
      ->getMock();

    $database->expects($this->once())
      ->method('createConnection')
      ->willThrowException(new PDOException('Connection failed'));

    // EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Błąd połączenia z bazą danych !');

    // WHEN
    $database->connect();
  }

  public function testShouldReturnPdoObjectWhenCredentialsAreValid(): void
  {
    // GIVEN
    $config = ['host' => 'localhost', 'database' => 'test', 'user' => 'root', 'password' => ''];

    $pdoMock = $this->createMock(PDO::class);

    $database = $this->getMockBuilder(Database::class)
      ->setConstructorArgs([$config])
      ->onlyMethods(['createConnection'])
      ->getMock();

    $database->expects($this->once())
      ->method('createConnection')
      ->willReturn($pdoMock);

    // WHEN
    $result = $database->connect();

    // THEN
    $this->assertInstanceOf(PDO::class, $result);
  }

  public function testShouldCreatePdoConnectionUsingSqlite(): void
  {
    // GIVEN
    $config = []; 
    $database = new TestDatabase($config);


    // WHEN
    $pdo = $database->exposeCreateConnection('sqlite::memory:', '', '');

    // THEN
    $this->assertInstanceOf(PDO::class, $pdo);
  }
}

class TestDatabase extends Database
{
  public function exposeCreateConnection(string $dsn, string $user, string $password): PDO
  {
    return $this->createConnection($dsn, $user, $password);
  }
}