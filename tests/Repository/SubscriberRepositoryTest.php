<?php

namespace Tests\Repository;

use App\Exception\RepositoryException;
use App\Repository\SubscriberRepository;
use PDO;
use PHPUnit\Framework\TestCase;

class SubscriberRepositoryTest extends TestCase {
  private PDO $pdo;
  private SubscriberRepository $repository;


  public function setUp(): void {
    $this->pdo = new PDO('sqlite::memory:');
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $this->pdo->exec("CREATE TABLE subscribers (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        email TEXT NOT NULL UNIQUE,
        is_active INTEGER DEFAULT 1
      )
    ");

    $this->repository = new SubscriberRepository($this->pdo);
  }

  public function testShouldReturnOnlyActiveEmailsWhenGetActiveEmailsIsCalled(): void {
    // GIVEN 
    $this->pdo->exec("INSERT INTO subscribers (email, is_active) VALUES ('test1@gmail.com', 1)");
    $this->pdo->exec("INSERT INTO subscribers (email, is_active) VALUES ('test2@gmail.com', 0)");
    $this->pdo->exec("INSERT INTO subscribers (email, is_active) VALUES ('test3@gmail.com', 1)");

    $emails = $this->repository->getActiveEmails();

    $this->assertCount(2, $emails);
    $this->assertEquals('test1@gmail.com', $emails[0]['email']);
    $this->assertEquals('test3@gmail.com', $emails[1]['email']);
  }

  public function testShouldThrowRepositoryExceptionWhenGetAllEmailsFailure(): void
  {
    // GIVEN
    $repository = $this->getMockBuilder(SubscriberRepository::class)
      ->disableOriginalConstructor()
      ->onlyMethods(['runQuery'])
      ->getMock();

    $repository->method('runQuery')
      ->willThrowException(new RepositoryException("Błąd bazy"));

    // EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage("Nie udało się pobrać subskrybentów");

    // WHEN
    $repository->getActiveEmails();
  }
}