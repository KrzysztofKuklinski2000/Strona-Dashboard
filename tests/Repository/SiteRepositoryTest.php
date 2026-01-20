<?php 

namespace Tests\Repository;

use PDO;
use PHPUnit\Framework\TestCase;
use App\Repository\SiteRepository;
use App\Exception\RepositoryException;

class SiteRepositoryTest extends TestCase {
  private PDO $pdo;
  private SiteRepository $repository;


  public function setUp(): void {
    $this->pdo = new PDO('sqlite::memory:');
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $this->repository = new SiteRepository($this->pdo);

    $this->pdo->exec("CREATE TABLE news (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT,
        description TEXT,
        created TEXT,
        updated TEXT,
        status INTEGER,
        position INTEGER
    )");

    $this->pdo->exec("CREATE TABLE gallery (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        image_name TEXT,   
        description TEXT,  
        created TEXT,      
        updated TEXT,  
        category TEXT,
        status INTEGER,
        position INTEGER
    )");
  }

  public function testShouldReturnDataWhenGetData(): void 
  {
    // GIVEN
    $sql = "INSERT INTO news (title, description, created, updated ,status, position) 
    VALUES (:title, :description, :created, :updated, :status, :position)";
    $this->repository->runQuery($sql, [
      ':title' => 'Test Title',
      ':description' => 'Test Content',
      ':created' => '2024-01-01',
      ':updated' => '2024-01-01',
      ':status' => 1,
      ':position' => 1
    ]);

    $this->repository->runQuery($sql, [
      ':title' => 'Test Title',
      ':description' => 'Test Content',
      ':created' => '2024-01-01',
      ':updated' => '2024-01-01',
      ':status' => 0,
      ':position' => 2
    ]);

    // WHEN
    $result = $this->repository->getData('news');

    // THEN
    $this->assertCount(1, $result); 
    $this->assertEquals('Test Title', $result[0]['title']);
  }

  public function testShouldThrowRepositoryExceptionWhenGetDataFailure(): void
  {
    //EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie udało się pobrać danych');

    
    // GIVEN
    $this->repository->runQuery("DROP TABLE news");

    // WHEN
    $result = $this->repository->getData('news');
  }

  public function testShouldReturnDataWhenGetSingleRecord(): void
  {
    // GIVEN
    $sql = "INSERT INTO news (title, description, created, updated ,status, position) 
    VALUES (:title, :description, :created, :updated, :status, :position)";
    $this->repository->runQuery($sql, [
      ':title' => 'Test Title',
      ':description' => 'Test Content',
      ':created' => '2024-01-01',
      ':updated' => '2024-01-01',
      ':status' => 1,
      ':position' => 1
    ]);

    // WHEN
    $result = $this->repository->getSingleRecord('news');

    // THEN
    $this->assertNotEmpty($result);
    $this->assertEquals('Test Title', $result['title']);
  }

  public function testShouldThrowRepositoryExceptionWhenGetSingleRecordFailure(): void
  {
    //EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie udało się pobrać danych');


    // GIVEN
    $this->repository->runQuery("DROP TABLE news");

    // WHEN
    $result = $this->repository->getSingleRecord('news');
  }


  public function testShouldGetNewsWithPagination(): void
  {
    // GIVEN
    $sql = "INSERT INTO news (title, description, created, updated ,status, position) 
    VALUES (:title, :description, :created, :updated, :status, :position)";
    $this->repository->runQuery($sql, [
      ':title' => 'Test Title',
      ':description' => 'Test Content',
      ':created' => '2024-01-01',
      ':updated' => '2024-01-01',
      ':status' => 1,
      ':position' => 1
    ]);

    $this->repository->runQuery($sql, [
      ':title' => 'Test Title 2',
      ':description' => 'Test Content',
      ':created' => '2024-01-01',
      ':updated' => '2024-01-01',
      ':status' => 1,
      ':position' => 2
    ]);

    // WHEN
    $result = $this->repository->getNews(1, 1);

    // THEN
    $this->assertEquals('Test Title 2', $result[0]['title']);
  }

  public function testShouldReturnEmptyArrayWhenNewsNotFound(): void
  {

    // WHEN
    $result = $this->repository->getNews(1, 1);

    // THEN
    $this->assertIsArray($result);
    $this->assertCount(0, $result);
  }

  public function testShouldThrowRepositoryExceptionWhenGetNewsFailure(): void {
    //EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie udało się pobrać aktualności');


    // GIVEN
    $this->repository->runQuery("DROP TABLE news");

    // WHEN
    $result = $this->repository->getNews(1,1);
  }

  public function testShouldReturnGalleryDataForStatusOneWhenGetGallery(): void
  {
    // GIVEN
    $sql = "INSERT INTO gallery (image_name, description, created, updated ,status, position, category) 
    VALUES (:image_name, :description, :created, :updated, :status, :position, :category)";

    $this->repository->runQuery($sql, [
      ':image_name' => 'fake1.jpg',
      ':description' => 'Test Content',
      ':created' => '2024-01-01',
      ':updated' => '2024-01-01',
      ':status' => 1,
      ':position' => 1,
      ':category' => 'camp'
    ]);

    $this->repository->runQuery($sql, [
      ':image_name' => 'fake2.jpg',
      ':description' => 'Test Content',
      ':created' => '2024-01-01',
      ':updated' => '2024-01-01',
      ':status' => 0,
      ':position' => 2,
      ':category' => 'trening'
    ]);

    // WHEN
    $result = $this->repository->getGallery();

    // THEN
    $this->assertCount(1, $result);
    $this->assertEquals('fake1.jpg', $result[0]['image_name']);
  }

  public function testShouldReturnGalleryDataForStatusOneAndTrainingrCampWhenGetGallery(): void
  {
    // GIVEN
    $sql = "INSERT INTO gallery (image_name, description, created, updated ,status, position, category) 
    VALUES (:image_name, :description, :created, :updated, :status, :position, :category)";

    $this->repository->runQuery($sql, [
      ':image_name' => 'fake1.jpg',
      ':description' => 'Test Content',
      ':created' => '2024-01-01',
      ':updated' => '2024-01-01',
      ':status' => 1,
      ':position' => 1,
      ':category' => 'camp'
    ]);

    $this->repository->runQuery($sql, [
      ':image_name' => 'fake2.jpg',
      ':description' => 'Test Content',
      ':created' => '2024-01-01',
      ':updated' => '2024-01-01',
      ':status' => 1,
      ':position' => 2,
      ':category' => 'training'
    ]);

    // WHEN
    $result = $this->repository->getGallery('training');

    // THEN
    $this->assertCount(1, $result);
    $this->assertEquals('fake2.jpg', $result[0]['image_name']);
  }

  public function testShouldReturnEmptyArrayWhenGalleryNotFound(): void
  {

    // WHEN
    $result = $this->repository->getGallery();

    // THEN
    $this->assertIsArray($result);
    $this->assertCount(0, $result);
  }

  public function testShouldThrowRepositoryExceptionWhenGetGalleryFailure(): void
  {
    //EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie udało się pobrać galeri');


    // GIVEN
    $this->repository->runQuery("DROP TABLE gallery");

    // WHEN
    $result = $this->repository->getGallery();
  }

  public function testShouldReturnNumberOfNewsDataWhenCountData(): void
  {
    // GIVEN
    $sql = "INSERT INTO news (title, description, created, updated ,status, position) 
    VALUES (:title, :description, :created, :updated, :status, :position)";
    $this->repository->runQuery($sql, [
      ':title' => 'Test Title',
      ':description' => 'Test Content',
      ':created' => '2024-01-01',
      ':updated' => '2024-01-01',
      ':status' => 1,
      ':position' => 1
    ]);

    $this->repository->runQuery($sql, [
      ':title' => 'Test Title 2',
      ':description' => 'Test Content',
      ':created' => '2024-01-01',
      ':updated' => '2024-01-01',
      ':status' => 1,
      ':position' => 2
    ]);

    $this->repository->runQuery($sql, [
      ':title' => 'Test Title 3',
      ':description' => 'Test Content',
      ':created' => '2024-01-01',
      ':updated' => '2024-01-01',
      ':status' => 0,
      ':position' => 3
    ]);

    // WHEN
    $result = $this->repository->countData('news');

    // THEN
    $this->assertEquals(3, $result);
  }

  public function testShouldThrowRepositoryExceptionWhenCountDataFailure(): void
  {
    //EXPECTS
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Nie udało się pobrać liczby rekordów');

    // GIVEN
    $this->repository->runQuery("DROP TABLE news");

    // WHEN
    $result = $this->repository->countData('news');
  
  }
}