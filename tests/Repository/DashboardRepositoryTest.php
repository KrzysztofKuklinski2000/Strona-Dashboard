<?php

namespace Tests\Repository;

use App\Exception\NotFoundException;
use PDO;
use PHPUnit\Framework\TestCase;
use App\Exception\RepositoryException;
use App\Repository\DashboardRepository;


class DashboardRepositoryTest extends TestCase
{
  private PDO $pdo;
  private DashboardRepository $repository;


  public function setUp(): void
  {
    $this->pdo = new PDO('sqlite::memory:');
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $this->repository = new DashboardRepository($this->pdo);

    $this->pdo->exec("CREATE TABLE news (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title VARCHAR(60),
        description TEXT,
        created DATE,
        updated DATE,
        status TINYINT,
        position INTEGER DEFAULT 1
    )");

    $sql = "INSERT INTO news (title, description, created, updated ,status, position) 
    VALUES (:title, :description, :created, :updated, :status, :position)";
    $this->repository->runQuery($sql, [
      ':title' => 'Test Title',
      ':description' => 'Test Content',
      ':created' => '2024-01-01',
      ':updated' => '2024-01-01',
      ':status' => 1,
      ':position' => 2
    ]);

    $this->repository->runQuery($sql, [
      ':title' => 'Test Title 2',
      ':description' => 'Test Content',
      ':created' => '2024-01-01',
      ':updated' => '2024-01-01',
      ':status' => 0,
      ':position' => 1
    ]);

    $this->pdo->exec("CREATE TABLE contact (
        email TEXT,
        phone INTEGER(11),
        address TEXT
    )");

    $this->pdo->exec("CREATE TABLE gallery (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        image_name TEXT,   
        description VARCHAR(50),
        created DATE,      
        updated DATE,  
        position INTEGER DEFAULT 1,
        category TEXT DEFAULT NULL,
        status TINYINT DEFAULT 1
        )");
  }


  public function testShouldReturnOrderDataWhenGetDashboardDataForNewsTable(): void {
    // WHEN
    $result = $this->repository->getDashboardData('news');

    // THEN
    $this->assertCount(2, $result);
    $this->assertEquals('Test Title 2', $result[0]['title']);
  }

  public function testShouldReturnDataWithoutOrderWhenGetDashboardDataForContactTable(): void 
  {
    // GIVEN
    $sql = "INSERT INTO contact (email, phone, address) VALUES (:email, :phone, :address)";
    $this->repository->runQuery($sql, [
        ':email' => 'text@gmail.com',
        ':phone' => 123456789,
        ':address' => 'Test Address'
    ]);

    // WHEN 
    $result = $this->repository->getDashboardData('contact');

    // THEN
    $this->assertCount(1, $result);
    $this->assertEquals('text@gmail.com', $result[0]['email']);
  }

  public function testShouldThrowRepositoryExceptionWhenInvalidTableGiven(): void 
  {
    //EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie udało się pobrać danych');

    // WHEN 
    $this->repository->getDashboardData('invalid_table');
  }

  public function testShouldThrowRepositoryExceptionWhenTableDoesNotExist(): void 
  {
    //EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie udało się pobrać danych');

    $this->repository->runQuery("DROP TABLE news");
    // WHEN 
    $this->repository->getDashboardData('news');
  }
  
  public function testShouldReturnSingleRecordFromTableWhenGetPostWithTableAndId(): void 
  {
    // WHEN
    $result = $this->repository->getPost(2, 'news');

    // THEN 
    $this->assertEquals('Test Title 2', $result['title']);
  }

  public function testShouldThrowRepositoryExceptionWhenInvalidTableGivenForGetPost(): void 
  {
    //EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie udało się pobrać posta');

    // WHEN
    $this->repository->getPost(1, 'invalid_table');
  }

  public function testShouldThrowRepositoryExceptionWhenTableDoesNotExistForGetPost(): void 
  {
    // EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie udało się pobrać posta');

    $this->repository->runQuery("DROP TABLE news");
    // WHEN
    $this->repository->getPost(1, 'news');
  }

  public function testShouldThrowNotFoundExceptionWhenPostNotFound(): void 
  {
    // EXPECTS
    $this->expectException(NotFoundException::class);
    $this->expectExceptionMessage('Nie ma takiego posta');

    // WHEN
    $this->repository->getPost(3, 'news');
  }

  

  public function testShouldUpdatePostDataForNewsTableWhenEditAndIdGiven(): void 
  {
    // GIVEN
    $data = [
      'id' => 2,
      'title' => 'Nowy Post',
      'description' => 'Test Content',
      'created' => '2024-01-01',
      'updated' => '2024-01-01',
      'status' => 1,
      'position' => 2
      ];

    // WHEN 
    $this->repository->edit('news', $data);

    // THEN
    $result = $this->repository->getPost(2, 'news');

    $this->assertEquals('Nowy Post', $result['title']);
  }

  public function testShouldUpdatePostDataForContactTableWhenEditWitoutId(): void
  {
    // GIVEN
    $sql = "INSERT INTO contact (email, phone, address) VALUES (:email, :phone, :address)";
    $this->repository->runQuery($sql, [
      ':email' => 'text@gmail.com',
      ':phone' => 123456789,
      ':address' => 'Test Address'
    ]);

    $newData = [
      'email' => 'new@gmail.com',
      'phone' => 123456789,
      'address' => 'Test Address'
    ];
    // WHEN
    $this->repository->edit('contact', $newData);

    // THEN
    $result = $this->repository->getDashboardData('contact');

    $this->assertEquals('new@gmail.com', $result[0]['email']);
  }

  public function testShouldNotUpdateDataForNewWhenEditAndIdMissing(): void 
  {
    // GIVEN
    $data = [
      'title' => 'Nowy Post',
      'description' => 'Test Content',
      'created' => '2024-01-01',
      'updated' => '2024-01-01',
      'status' => 1,
      'position' => 2
    ];

    // WHEN 
    $this->repository->edit('news', $data);

    // THEN
    $result = $this->repository->runQuery("SELECT * FROM news")->fetchAll(PDO::FETCH_ASSOC);

    $this->assertEquals('Test Title', $result[0]['title']);
    $this->assertEquals('Test Title 2', $result[1]['title']);
  }

  public function testShouldThrowRepositoryExceptionWhenIdIsGivenButTableDoesNotNeedIdToUpdate(): void
  {
    //EXCEPTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie udało się edytować posta');

    // GIVEN
    $sql = "INSERT INTO contact (email, phone, address) VALUES (:email, :phone, :address)";
    $this->repository->runQuery($sql, [
      ':email' => 'text@gmail.com',
      ':phone' => 123456789,
      ':address' => 'Test Address'
    ]);

    $newData = [
      'id' => 1,
      'email' => 'new@gmail.com',
      'phone' => 123456789,
      'address' => 'Test Address'
    ];
    // WHEN
    $this->repository->edit('contact', $newData);
  }

  public function testShouldThrowRepositoryExceptionWhenInvalidTableIsGiven(): void 
  {
    //EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie udało się edytować posta');

    // WHEN
    $this->repository->edit('invalid_table', []);
  }

  public function testShouldThrowRepositoryExceptionWhenTableDoesNotExistForEdit(): void
  {
    //EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie udało się edytować posta');

    $this->repository->runQuery("DROP TABLE news");

    // WHEN
    $this->repository->edit('news', []);
  }

  public function testShouldThrowRepositoryExceptionForEmptyDataForEdit(): void
  {
    // EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie udało się edytować posta');

    // GIVEN
    $data = [];

    // WHEN 
    $this->repository->edit('news', $data);
  }

  public function testShouldChangePostionForNewsWhenMovePositionMethodIsCalled(): void 
  {
    // GIVEN 
    $params = [
      ':pos' => 2,
      ':id' => 2
    ];

    // WHEN
    $this->repository->movePosition('news', $params);

    // THEN
    $resul = $this->repository->getPost(2, 'news');

    $this->assertEquals(2, $resul['position']);
  }

  public function testShouldThrowRepositoryExceptionWhenInvalidTableIsGivenForMovePosition(): void 
  {
    //EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie udało się zmienić pozycji');

    // WHEN
    $this->repository->movePosition('invalid_table', []);
  }

  public function testShouldThrowRepositoryExceptionWhenTableDoesNotExistForMovePosition(): void 
  {
    //EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie udało się zmienić pozycji');

    // GIVEN 
    $this->repository->runQuery("DROP TABLE news");

    // WHEN
    $this->repository->movePosition('news', []);
  }

  public function testShouldDoNothingWhenDataAreMissingForMovePosition(): void 
  {
    // GIVEN  
    $params = [
    ];

    // WHEN
    $this->repository->movePosition('news', $params);

    // THEN
    $resul = $this->repository->getPost(2, 'news');

    $this->assertEquals(1, $resul['position']);
  }
}