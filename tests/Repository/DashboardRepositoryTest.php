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

    // ID: 1
    $this->repository->runQuery($sql, [
      ':title' => 'Test Title',
      ':description' => 'Test Content',
      ':created' => '2024-01-01',
      ':updated' => '2024-01-01',
      ':status' => 1,
      ':position' => 2
    ]);

    // ID: 2
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
        created_at DATE,      
        updated_at DATE,  
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

  public function testShouldReturnPostDataWhenGetPostByPosition(): void 
  {
    // WHEN 
    $result =$this->repository->getPostByPosition('news', 2);

    // THEN
    $this->assertNotEmpty($result);
    $this->assertArrayHasKey('title', $result);
    $this->assertEquals('Test Title', $result['title']);
  }

  public function testShouldThrowRepositoryExceptionWhenInvalidTableIsGivenForGetPostByPosition(): void
  {
    // EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie udało się pobrać elementu');

    // WHEN
    $this->repository->getPostByPosition('invalid_table', 1);
  }

  public function testShouldThrowRepositoryExceptionWhenTableDoesNotExistForGetPostByPosition(): void 
  {
    // EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie udało się pobrać elementu');

    // GIVEN
    $this->repository->runQuery("DROP TABLE news");    
    // WHEN
    $this->repository->getPostByPosition('news', 1);
  }

  public function testShouldReturnEmptyArrayWhenPostNotFoundForGetPostByPosition(): void 
  {
    // WHEN
    $result = $this->repository->getPostByPosition('news', 3);

    // THEN
    $this->assertIsArray($result);
    $this->assertCount(0, $result);
  }

  public function testShouldIncrementPositionValueWhenIncrementPositionMethodIsCalled(): void 
  {
    // WHEN
    $this->repository->incrementPosition('news');

    // THEN
    $result = $this->repository->getDashboardData('news');

    $this->assertEquals(2, $result[0]['position']);
    $this->assertEquals(3, $result[1]['position']);
  }

  public function testShouldThrowRepositoryExceptionWhenInvalidTableIsGivenForIncrementPosition(): void 
  {
    // EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie udało się zmienić pozycji');
    
    // WHEN
    $this->repository->incrementPosition('invalid_table');
  }

  public function testShouldThrowRepositoryExceptionWhenTableDoesNotExistForIncrementPosition(): void 
  {
    // EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie udało się zmienić pozycji');

    // GIVEN
    $this->repository->runQuery("DROP TABLE news");

    // WHEN
    $this->repository->incrementPosition('news');
  }

  public function testShouldDecrementPositionsGreaterThanGivenValue(): void
  {
    // GIVEN
    $sql = "INSERT INTO news (title, position) VALUES (:title, :pos)";
    $this->repository->runQuery($sql, [':title' => 'Post 10', ':pos' => 10]);
    $this->repository->runQuery($sql, [':title' => 'Post 11', ':pos' => 11]);

    // WHEN
    $this->repository->decrementPosition('news', 9);

    // THEN
    $result = $this->repository->runQuery("SELECT title, position FROM news")->fetchAll(PDO::FETCH_ASSOC);

    $this->assertEquals(9, $result[2]['position']);
    $this->assertEquals(10, $result[3]['position']);
  }

  public function testShouldNotChangePositionsWhenNoItemsAreGreaterThanGivenPosition(): void
  {
    // WHEN
    $this->repository->decrementPosition('news', 5);

    // THEN
    $result = $this->repository->runQuery("SELECT title, position FROM news")->fetchAll(PDO::FETCH_ASSOC);

    $this->assertEquals(2, $result[0]['position']);
    $this->assertEquals(1, $result[1]['position']);
  }

  public function testShouldThrowRepositoryExceptionWhenTableDoesNotExistForDecrementPosition(): void
  {
    // EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie udało się zmienić pozycji');

    // GIVEN
    $this->repository->runQuery("DROP TABLE news");

    // WHEN
    $this->repository->decrementPosition('news', 1);
  }

  public function testShouldThrowRepositoryExceptionWhenInvalidTableIsGivenForDecrementPosition(): void
  {
    // EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie udało się zmienić pozycji');

    // WHEN
    $this->repository->decrementPosition('invalid_table', 1);
  }

  public function testShouldDeletePostWhenDeleteMethodIsCalled(): void 
  {
    // WHEN
    $this->repository->delete(2, 'news');

    // THEN
    $result = $this->repository->getDashboardData('news');

    $this->assertCount(1, $result);
    $this->assertEquals('Test Title', $result[0]['title']);
  }

  public function testShouldThrowRepositoryExceptionWhenInvalidTableIsGivenForDelete(): void 
  {
    // EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie udało się usunąć posta');

    // WHEN
    $this->repository->delete(1, 'invalid_table');
  }

  public function testShouldThrowRepositoryExceptionWhenTableDoesNotExistForDeleteMethod(): void 
  {
    // EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie udało się usunąć posta');

    // GIVEN
    $this->repository->runQuery("DROP TABLE news");

    // WHEN
    $this->repository->delete(1, 'news');
  }

  public function testShouldCreateNewPostInNewsTable(): void
  {
    // GIVEN
    $newPost = [
      'title' => 'New Post',
      'description' => 'Description',
      'created' => '2024-02-02',
      'updated' => '2024-02-02',
      'status' => 1,
      'position' => 10
    ];

    // WHEN
    $this->repository->create($newPost, 'news');

    // THEN
    $result = $this->repository->runQuery("SELECT * FROM news WHERE title = 'New Post'")->fetch(PDO::FETCH_ASSOC);

    $this->assertEquals('New Post', $result['title']);
  }

  public function testShouldThrowRepositoryExceptionWhenIdIsGivenForCreateMethod(): void
  {
    // EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie udało się utworzyć posta');

    // GIVEN
    $data = [
      'id' => 9999,
      'title' => 'test',
      'description' => 'Desc',
      'created' => '2024-01-01',
      'updated' => '2024-01-01',
      'status' => 1,
      'position' => 3
    ];

    // WHEN
    $this->repository->create($data, 'news');
  }

  public function testShouldCreateRecordInContactTable(): void
  {
    // GIVEN
    $contactData = [
      'email' => 'new.contact@gmail.com',
      'phone' => 987654321,
      'address' => 'Warszawa'
    ];

    // WHEN
    $this->repository->create($contactData, 'contact');

    // THEN
    $result = $this->repository->runQuery("SELECT * FROM contact WHERE email = 'new.contact@gmail.com'")->fetch(PDO::FETCH_ASSOC);

    $this->assertEquals('new.contact@gmail.com', $result['email']);
  }

  public function testShouldThrowExceptionWhenDataContainsInvalidColumn(): void
  {
    // EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie udało się utworzyć posta');

    // GIVEN
    $badData = [
      'title' => 'Test',
      'kolumna_ktora_nie_istnieje' => 'test'
    ];

    // WHEN
    $this->repository->create($badData, 'news');
  }

  public function testShouldThrowExceptionWhenTableIsDroppedForCreate(): void
  {
    // EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie udało się utworzyć posta');

    // GIVEN
    $this->repository->runQuery("DROP TABLE news");

    $data = ['title' => 'test'];

    // WHEN
    $this->repository->create($data, 'news');
  }

  public function testShouldThrowExceptionWhenInvalidTableGivenForCreate(): void
  {
    // EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie udało się utworzyć posta');

    // WHEN
    $this->repository->create(['title' => 'Test'], 'invalid_table');
  }

  public function testShouldChangeStatusToPublished(): void
  {
    // GIVEN
    $before = $this->repository->runQuery("SELECT status FROM news WHERE id = 2")->fetchColumn();

    $data = [
      'id' => 2,
      'published' => 1
    ];

    // WHEN
    $this->repository->published($data, 'news');

    // THEN
    $after = $this->repository->runQuery("SELECT status FROM news WHERE id = 2")->fetchColumn();
    $this->assertEquals(1, $after);
  }

  public function testShouldChangeStatusToUnpublished(): void
  {
    // GIVEN
    $data = [
      'id' => 1,
      'published' => 0
    ];

    // WHEN
    $this->repository->published($data, 'news');

    // THEN
    $after = $this->repository->runQuery("SELECT status FROM news WHERE id = 1")->fetchColumn();
    $this->assertEquals(0, $after);
  }

  public function testShouldThrowExceptionWhenTableIsDroppedForPublished(): void
  {
    // EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie udało się zmienić statusu');

    // GIVEN
    $this->repository->runQuery("DROP TABLE news");

    $data = ['id' => 1, 'published' => 0];

    // WHEN
    $this->repository->published($data, 'news');
  }

  public function testShouldThrowExceptionWhenInvalidTableGivenForPublished(): void
  {
    // EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie udało się zmienić statusu');

    // WHEN
    $this->repository->published(['id' => 1, 'published' => 1], 'invalid_table');
  }

  public function testShouldAddImageToGallerySuccessfully(): void
  {
    // GIVEN

    $imageData = [
      'image_name' => 'summer_camp.jpg',
      'description' => 'Super obóz',
      'created_at' => '2024-06-01',
      'updated_at' => '2024-06-01',
      'category' => 'camp'
    ];

    // WHEN
    $this->repository->addImage($imageData);

    // THEN
    $result = $this->repository->runQuery("SELECT * FROM gallery WHERE image_name = 'summer_camp.jpg'")->fetch(PDO::FETCH_ASSOC);

    $this->assertNotFalse($result);
    $this->assertEquals('Super obóz', $result['description']);
    $this->assertEquals('camp', $result['category']);
  }

  public function testShouldThrowExceptionWhenTableIsMissingForAddImage(): void
  {
    // EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie udało się dodać zdjęcia');

    // GIVEN
    $this->repository->runQuery("DROP TABLE gallery");

    $imageData = [
      'image_name' => 'test.jpg',
      'description' => 'desc',
      'created_at' => '2024-01-01',
      'updated_at' => '2024-01-01',
      'category' => 'training'
    ];

    // WHEN
    $this->repository->addImage($imageData);
  }
}