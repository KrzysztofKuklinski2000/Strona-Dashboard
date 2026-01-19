<?php

namespace Tests\Repository;

use PDO;
use PHPUnit\Framework\TestCase;
use App\Repository\AbstractRepository;
use App\Exception\RepositoryException;

class TestRepository extends AbstractRepository
{
  public function checkTable(string $table): string
  {
    return $this->validateTable($table);
  }
}

class AbstractRepositoryTest extends TestCase
{
  private object $repository;
  private PDO $pdo;

  public function setUp(): void
  {
    $this->pdo = new PDO('sqlite::memory:');
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $this->pdo->exec("CREATE TABLE timetable (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            day TEXT,
            start TEXT,
            city TEXT,
            advancement_group TEXT
        )");

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

  public function testShouldSortDataFromTimetablePage(): void
  {
    // GIVEN
    $this->pdo->exec("INSERT INTO timetable (day, start) VALUES ('ŚR', '10:00')");
    $this->pdo->exec("INSERT INTO timetable (day, start) VALUES ('PON', '10:00')");

    // WHEN
    $result = $this->repository->timetablePageData();

    // THEN
    $this->assertEquals('PON', $result[0]['day']);
    $this->assertEquals('ŚR', $result[1]['day']);
  }

  public function testShouldThrowRepositoryExceptionWhenTimetablePageDataMissingTable(): void
  {
    // GIVEN
    $this->repository->runQuery("DROP TABLE timetable");

    // EXPECT
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie udało się pobrać danych grafiku.');

    // WHEN
    $this->repository->timetablePageData();
  }

  public function testShouldSaveDataWhenTransactionCommit():void 
  {
    // GIVEN 
    $sql = "INSERT INTO timetable (day, start) VALUES (:day, :start)";

    // WHEN 
    $this->repository->beginTransaction();

    $this->repository->runQuery($sql);

    $this->repository->commit();

    // THEN 
    $result = $this->repository->runQuery("SELECT * FROM timetable")->fetchAll(PDO::FETCH_ASSOC);

    $this->assertCount(1, $result);
  }

  public function testShouldRollbackDataWhenTransactionRollback():void 
  {
    // GIVEN
    $sql = "INSERT INTO timetable (day, start) VALUES (:day, :start)";

    //WHEN
    $this->repository->beginTransaction();

    $this->repository->runQuery($sql);

    $this->repository->rollback();

    // THEN 
    $result = $this->repository->runQuery("SELECT * FROM timetable")->fetchAll(PDO::FETCH_ASSOC);

    $this->assertCount(0, $result);
  }

  public function testShouldReturnFalseWhenNoTransactionIsActive(): void {
    // WHEN 
    $result = $this->repository->rollback();

    // THEN 
    $this->assertFalse($result);
  }
}
