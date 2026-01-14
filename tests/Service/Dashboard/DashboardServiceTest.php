<?php 

namespace Tests\Service\Dashboard;

use App\Core\FileHandler;
use PHPUnit\Framework\TestCase;
use App\Exception\FileException;
use App\Exception\ServiceException;
use App\Exception\RepositoryException;
use App\Repository\DashboardRepository;
use App\Service\Dashboard\DashboardService;
use PHPUnit\Framework\MockObject\MockObject;

class DashboardServiceTest extends TestCase {
  private DashboardRepository | MockObject $repository;
  private FileHandler | MockObject $fileHandler;
  private DashboardService  $service;

  public function setUp(): void
  {
    $this->repository = $this->createMock(DashboardRepository::class);
    $this->fileHandler = $this->createMock(FileHandler::class);

    $this->service = new DashboardService($this->repository, $this->fileHandler);
  }


  public function testShouldCreateNewsSuccessfully(): void
  {
    // GIVEN
    $data = ['title' => 'News'];

    // EXPECTS
    $this->repository->expects($this->once())
      ->method('beginTransaction');

    $this->repository->expects($this->once())
      ->method('incrementPosition')
      ->with('news');

    $this->repository->expects($this->once())
      ->method('create')
      ->with($data, 'news');

    $this->repository->expects($this->once())
      ->method('commit');

    // WHEN
    $this->service->createNews($data);
  }

  public function testShouldRollbackTransactionOnCreateFailure(): void {
    // EXPECTS
    $this->expectException(ServiceException::class);

    $this->repository->expects($this->once())
      ->method('rollback');

    // WHEN 
    $this->repository->method('create')
      ->willThrowException(new RepositoryException('Błąd'));

    $this->service->createNews(['title']);  
  }

  public function testShouldDeleteNewsAndDecrementPositions(): void {
    // GIVEN 
    $id = 1;
    $postPosition = 5;
    $postData = ['id' => $id, 'position' => $postPosition];

    // EXPECTS
    $this->repository->expects($this->once())
      ->method('beginTransaction');

    $this->repository->expects($this->once())
      ->method('getPost')
      ->with($id, 'news')
      ->willReturn($postData);

    $this->repository->expects($this->once())
      ->method('delete')
      ->with($id, 'news');


    $this->repository->expects($this->once())
      ->method('decrementPosition')
      ->with('news', $postPosition);

    $this->repository->expects($this->once())
      ->method('commit');

    // WHEN 
    $this->service->deleteNews($id);

  }

  public function testShouldUpdateNews(): void {
    // GIVEN
    $data = ['title' => 'News'];

    // EXPECTS
    $this->repository->expects($this->once())
      ->method('edit')
      ->with('news', $data);

    // WHEN 
    $this->service->updateNews($data);
  }

  public function testShouldGetAllNews(): void {
    // GIVEN 
    $news = [
      [
      'id' => 1, 
      'title' => 'test', 
      'description' =>'test', 
      'created'=>'2026-01-01', 
      'updated'=>'2026-01-01',
      'status' => 1,  
      'position' => 1
      ],
      [
        'id' => 2,
        'title' => 'test2',
        'description' => 'test2',
        'created' => '2026-01-01',
        'updated' => '2026-01-01',
        'status' => 1,
        'position' => 2
      ],
    ];

    //EXPECTS 
    $this->repository->method('getDashboardData')
      ->with('news')
      ->willReturn($news);

    // WHEN 
    $actual = $this->service->getAllNews();
    

    // THEN 
    $this->assertEquals($actual, $news);
  
  }

  public function testShouldPublishNews(): void {
    // GIVEN
    $data = ['id' => 1, 'status' => 1];

    // EXPECTS
    $this->repository->expects($this->once())
      ->method('published')
      ->with($data, 'news');

    // WHEN
    $this->service->publishedNews($data);
  }

  public function testShouldMoveNewsUp(): void {
    // GIVEN
    $table = 'news';
    $currentPost = ['id' => 10, 'position' => 5];
    $neighborPost  = ['id' => 11, 'position' => 4];
    $inputData = ['id' => 10, 'dir' => 'up'];

    // EXPECTS
    $this->repository->expects($this->once())->method('beginTransaction');

    $this->repository->expects($this->once())
      ->method('getPost')
      ->with(10, $table)
      ->willReturn($currentPost);

    $this->repository->expects($this->once())
      ->method('getPostByPosition')
      ->with($table, 4) // $currentPost['position'] - 1 => 4
      ->willReturn($neighborPost);


    $this->repository->expects($this->exactly(2))
      ->method('movePosition');

    $this->repository->expects($this->once())->method('commit');

    // WHEN 
    $this->service->moveNews($inputData);
  
  }

  public function testShouldMoveNewsDown(): void
  {
    // GIVEN
    $table = 'news';
    $currentPost = ['id' => 10, 'position' => 5];
    $neighborPost  = ['id' => 11, 'position' => 6];
    $inputData = ['id' => 10, 'dir' => 'down'];

    // EXPECTS
    $this->repository->expects($this->once())->method('beginTransaction');

    $this->repository->expects($this->once())
      ->method('getPost')
      ->with(10, $table)
      ->willReturn($currentPost);

    $this->repository->expects($this->once())
      ->method('getPostByPosition')
      ->with($table, 6) // $currentPost['position'] + 1 => 6
      ->willReturn($neighborPost);


    $this->repository->expects($this->exactly(2))
      ->method('movePosition');

    $this->repository->expects($this->once())->method('commit');

    // WHEN 
    $this->service->moveNews($inputData);
  }

  public function testShouldNotMoveWhenNoNeighborFound(): void
  {
    $table = 'news';
    $currentPost = ['id' => 10, 'position' => 1];
    $inputData = ['id' => 10, 'dir' => 'up'];

    // EXPECTS
    $this->repository->expects($this->once())->method('beginTransaction');

    $this->repository->expects($this->once())
      ->method('getPost')
      ->with(10, $table)
      ->willReturn($currentPost);

    $this->repository->expects($this->once())
      ->method('getPostByPosition')
      ->with($table, 0) // $currentPost['position'] - 1 => 0
      ->willReturn(false);


    $this->repository->expects($this->never())
      ->method('movePosition');

    $this->repository->expects($this->once())->method('commit');

    // WHEN 
    $this->service->moveNews($inputData);

  }

  public function testShouldRollbackTransactionOnMoveFailure(): void {
    // EXPECTS
    $this->expectException(ServiceException::class);

    $this->repository->expects($this->once())
      ->method('beginTransaction');
    
    $this->repository->expects($this->once())
      ->method('rollback');

    // WHEN 
    $this->repository->method('getPost')
      ->willThrowException(new RepositoryException('Błąd'));

    $this->service->moveNews(['id' => 10, 'dir' => 'up']);
  }

  public function testShouldCreateGalleryAndUploadImage(): void {
    // GIVEN
    $fileData = ['tmp_name' => '/tmp/fakephp', 'name' => 'fake.jpg'];
    $inputData = ['image_name' => $fileData, 'title' => 'Test'];

    $uploadedFileName = 'unique_fake.jpg';

    $expectedDbData = [
      'image_name' => $uploadedFileName,
      'title' => 'Test'
      ];

    // EXPECTS
    $this->repository->expects($this->once())->method('beginTransaction');

    $this->fileHandler->expects($this->once())
      ->method('uploadImage')
      ->with($fileData)
      ->willReturn($uploadedFileName);

    $this->repository->expects($this->once())
      ->method('incrementPosition')
      ->with('gallery');
    
    $this->repository->expects($this->once())
      ->method('addImage')
      ->with($expectedDbData);

    $this->repository->expects($this->once())->method('commit');

    // WHEN 
    $this->service->createGallery($inputData);
  
  }

  public function testShouldThrowServiceExceptionOnImageUploaderFailure(): void {
    // GIVEN
    $fileData = ['tmp_name' => '/tmp/fakephp', 'name' => 'fake.jpg'];
    $inputData = ['image_name' => $fileData, 'title' => 'Test'];

    // EXPECT 
    $this->expectException(ServiceException::class);
    $this->expectExceptionMessage('Nie udało się dodać zdjęcia');

    $this->repository->expects($this->once())->method('beginTransaction');

    $this->repository->expects($this->once())->method('rollback');

    // WHEN 
    $this->fileHandler->method('uploadImage')
      ->with($fileData)
      ->willThrowException(new FileException('Błąd'));

    $this->service->createGallery($inputData);
  }

  public function testShouldRollbackTransactionWhenNoFileWasUploaded(): void {
    // GIVEN
    $fileData = ['error' => UPLOAD_ERR_NO_FILE];
    $inputData = ['image_name' => $fileData, 'title' => 'Test'];

    // EXPECT 
    $this->expectException(ServiceException::class);
    $this->expectExceptionMessage('Nie udało się dodać zdjęcia');

    $this->repository->expects($this->once())->method('beginTransaction');

    $this->repository->expects($this->once())->method('rollback');

    // WHEN 
    $this->fileHandler->method('uploadImage')
      ->with($fileData)
      ->willThrowException(new FileException('Błąd'));

    $this->service->createGallery($inputData);
  }

  public function testShouldRollbackAndThorwRepositoryExceptionWhenFailsAfterUpload(): void {
    // GIVEN
    $fileData = ['tmp_name' => '/tmp/fakephp', 'name' => 'fake.jpg'];
    $inputData = ['image_name' => $fileData, 'title' => 'Test'];

    // EXPECT 
    $this->expectException(ServiceException::class);
    $this->expectExceptionMessage('Nie udało się dodać zdjęcia');

    $this->repository->expects($this->once())->method('beginTransaction');

    $this->fileHandler->expects($this->once())
      ->method('uploadImage');

    $this->repository->expects($this->once())->method('rollback');

    // WHEN 
    $this->repository->method('incrementPosition')
      ->with('gallery')
      ->willThrowException(new RepositoryException('Błąd'));

    $this->service->createGallery($inputData);
  }
}