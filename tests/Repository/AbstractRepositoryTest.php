<?php

namespace Tests\Repository;

use PDO;
use PHPUnit\Framework\TestCase;
use App\Repository\AbstractRepository;
use App\Exception\RepositoryException;

class TestRepository extends AbstractRepository
{
}

class AbstractRepositoryTest extends TestCase
{
  private object $repository;
  private PDO $pdo;

  public function setUp(): void
  {
    $this->pdo = new PDO('sqlite::memory:');
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $this->repository = new TestRepository($this->pdo);
  }


  public function testShouldInsertAndSelectDataWhenRunQuery(): void {
    // GIVEN
    $this->repository->runQuery(
      "INSERT INTO timetable (day, start, city) VALUES (:day, :start, :city)",
      [':day' => 'PON', ':start' => '18:00', ':city' => 'Gdynia']
    );

    // WHEN
    $result = $this->repository->runQuery("SELECT * FROM timetable")->fetchAll(PDO::FETCH_ASSOC);



    // THEN
    $this->assertCount(1, $result);
    $this->assertEquals('PON', $result[0]['day']);

  }

  public function testShouldBindArrayParamsWhenRunQuery(): void
  {
    // GIVEN
    $sql = "INSERT INTO timetable (day, start, city) VALUES (:day, :start, :city)";
    $params = [
      ':day' => 'PON', 
      ':start' => '18:00', 
      ':city' => ['Gdynia', PDO::PARAM_STR]
    ];

    // WHEN
    $result = $this->repository->runQuery($sql, $params);



    // THEN
    $result = $this->repository->runQuery("SELECT * FROM timetable")->fetchAll(PDO::FETCH_ASSOC);

    $this->assertEquals('Gdynia', $result[0]['city']);
    $this->assertCount(1, $result);
  }

  public function testShouldThrowRepositoryExceptionWhenRunQueryFailuer(): void
  {
    // EXPECTS 
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Błąd bazy danych');

    //WHEN 
    $this->repository->runQuery('SELECT * FROM invalid_table');
  }

  public function testShouldValidTable(): void {
    //THEN
    $this->assertEquals('timetable', $this->repository->checkTable('timetable'));
  }

  public function testShouldThrowRepositoryExceptionWhenInvalidTable(): void
  {
    // EXPECTS 
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie ma takiej tabeli');

    //WHEN 
    $this->repository->checkTable('invalid_table');
  }



  public function testShouldReturnFalseWhenNoTransactionIsActive(): void {
    // WHEN 
    $result = $this->repository->rollback();

    // THEN 
    $this->assertFalse($result);
  }
}
