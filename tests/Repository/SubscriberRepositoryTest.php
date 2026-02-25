<?php

namespace Tests\Repository;

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
        email TEXT NOT NULL UNIQUE
      )
    ");

    $this->repository = new SubscriberRepository($this->pdo);
  }

  public function testShouldReturnListOfEmailsWhenGetAllEmailsIsCalled(): void {
    // GIVEN 
    $this->pdo->exec("INSERT INTO subscribers (email) VALUES ('jan@test.pl')");
    $this->pdo->exec("INSERT INTO subscribers (email) VALUES ('anna@test.pl')");

    $emails = $this->repository->getAllEmails();

    $this->assertCount(2, $emails);
    $this->assertEquals('jan@test.pl', $emails[0]);
    $this->assertEquals('anna@test.pl', $emails[1]);
  }
}