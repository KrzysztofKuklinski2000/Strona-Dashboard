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

class DashboardServiceTest extends TestCase
{
  private DashboardRepository | MockObject $repository;
  private FileHandler | MockObject $fileHandler;
  private DashboardService  $service;

  public function setUp(): void
  {
    $this->repository = $this->createMock(DashboardRepository::class);
    $this->fileHandler = $this->createMock(FileHandler::class);

    $this->service = new DashboardService($this->repository, $this->fileHandler);
  }

  // =========================================================================
  // SECTION: NEWS
  // =========================================================================

  public function testShouldCreateNewsSuccessfully(): void
  {
    // GIVEN
    $data = ['title' => 'News'];

    // EXPECTS
    $this->repository->expects($this->once())->method('beginTransaction');
    $this->repository->expects($this->once())->method('incrementPosition')->with('news');
    $this->repository->expects($this->once())->method('create')->with($data, 'news');
    $this->repository->expects($this->once())->method('commit');

    // WHEN
    $this->service->createNews($data);
  }

  public function testShouldThrowServiceExceptionWhenCreateNewsFailure(): void
  {
    // EXPECTS
    $this->expectException(ServiceException::class);
    $this->repository->expects($this->once())->method('rollback');

    // WHEN 
    $this->repository->method('create')->willThrowException(new RepositoryException('Błąd'));
    $this->service->createNews(['title']);
  }

  public function testShouldGetAllNews(): void
  {
    // GIVEN 
    $news = [
      ['id' => 1, 'title' => 'test', 'position' => 1],
      ['id' => 2, 'title' => 'test2', 'position' => 2],
    ];

    // EXPECTS 
    $this->repository->method('getDashboardData')->with('news')->willReturn($news);

    // WHEN / THEN 
    $this->assertEquals($news, $this->service->getAllNews());
  }

  public function testShouldThrowServiceExceptionWhenGetAllNewsFailure(): void
  {
    $this->expectException(ServiceException::class);
    $this->expectExceptionMessage('Nie udało się pobrać postów');
    $this->repository->method('getDashboardData')->willThrowException(new RepositoryException());
    $this->service->getAllNews();
  }

  public function testShouldGetSingleNewsPost(): void
  {
    // GIVEN
    $data = ['id' => 1, 'title' => 'test'];

    // EXPECTS 
    $this->repository->expects($this->once())
      ->method('getPost')
      ->with(1, 'news')
      ->willReturn($data);

    // WHEN / THEN
    $this->assertEquals($data, $this->service->getPost(1, 'news'));
  }

  public function testShouldThrowServiceExceptionWhenGetSingleNewsPostFailure(): void
  {
    $this->expectException(ServiceException::class);
    $this->expectExceptionMessage('Nie udało się pobrać posta');
    $this->repository->method('getPost')->willThrowException(new RepositoryException());
    $this->service->getPost(1, 'news');
  }

  public function testShouldUpdateNews(): void
  {
    // GIVEN
    $data = ['title' => 'News'];

    // EXPECTS
    $this->repository->expects($this->once())->method('edit')->with('news', $data);

    // WHEN 
    $this->service->updateNews($data);
  }

  public function testShouldThrowServiceExceptionWhenUpdateNewsFailure(): void
  {
    $this->expectException(ServiceException::class);
    $this->expectExceptionMessage('Nie udało się edytować');
    $this->repository->method('edit')->willThrowException(new RepositoryException('Błąd'));
    $this->service->updateNews(['title']);
  }

  public function testShouldPublishNews(): void
  {
    $data = ['id' => 1, 'status' => 1];
    $this->repository->expects($this->once())->method('published')->with($data, 'news');
    $this->service->publishedNews($data);
  }

  public function testShouldThrowServiceExceptionWhenPublishNewsFailure(): void
  {
    $this->expectException(ServiceException::class);
    $this->expectExceptionMessage('Nie udało się zmienić statusu');
    $this->repository->method('published')->willThrowException(new RepositoryException('Błąd'));
    $this->service->publishedNews(['title']);
  }

  public function testShouldDeleteNewsAndDecrementPositions(): void
  {
    // GIVEN 
    $id = 1;
    $postData = ['id' => 1, 'position' => 5];

    // EXPECTS
    $this->repository->expects($this->once())->method('beginTransaction');
    $this->repository->expects($this->once())->method('getPost')->with($id, 'news')->willReturn($postData);
    $this->repository->expects($this->once())->method('delete')->with($id, 'news');
    $this->repository->expects($this->once())->method('decrementPosition')->with('news', 5);
    $this->repository->expects($this->once())->method('commit');

    // WHEN 
    $this->service->deleteNews($id);
  }

  public function testShouldThrowServiceExceptionWhenDeleteNewsFailure(): void
  {
    $this->expectException(ServiceException::class);
    $this->expectExceptionMessage('Nie udało się usunąć posta');

    $this->repository->expects($this->once())->method('beginTransaction');
    $this->repository->method('getPost')->willThrowException(new RepositoryException('Błąd'));
    $this->repository->expects($this->once())->method('rollBack');

    $this->service->deleteNews(1);
  }

  public function testShouldMoveNewsUp(): void
  {
    // GIVEN
    $table = 'news';
    $currentPost = ['id' => 10, 'position' => 5];
    $neighborPost  = ['id' => 11, 'position' => 4];

    // EXPECTS
    $this->repository->expects($this->once())->method('beginTransaction');
    $this->repository->expects($this->once())->method('getPost')->with(10, $table)->willReturn($currentPost);
    $this->repository->expects($this->once())->method('getPostByPosition')->with($table, 4)->willReturn($neighborPost);
    $this->repository->expects($this->exactly(2))->method('movePosition');
    $this->repository->expects($this->once())->method('commit');

    // WHEN 
    $this->service->moveNews(['id' => 10, 'dir' => 'up']);
  }

  public function testShouldMoveNewsDown(): void
  {
    // GIVEN
    $table = 'news';
    $currentPost = ['id' => 10, 'position' => 5];
    $neighborPost  = ['id' => 11, 'position' => 6];

    // EXPECTS
    $this->repository->expects($this->once())->method('beginTransaction');
    $this->repository->expects($this->once())->method('getPost')->with(10, $table)->willReturn($currentPost);
    $this->repository->expects($this->once())->method('getPostByPosition')->with($table, 6)->willReturn($neighborPost);
    $this->repository->expects($this->exactly(2))->method('movePosition');
    $this->repository->expects($this->once())->method('commit');

    // WHEN 
    $this->service->moveNews(['id' => 10, 'dir' => 'down']);
  }

  public function testShouldNotMoveWhenNoNeighborFound(): void
  {
    $table = 'news';
    $currentPost = ['id' => 10, 'position' => 1];

    $this->repository->expects($this->once())->method('beginTransaction');
    $this->repository->expects($this->once())->method('getPost')->with(10, $table)->willReturn($currentPost);
    $this->repository->expects($this->once())->method('getPostByPosition')->with($table, 0)->willReturn([]);
    $this->repository->expects($this->never())->method('movePosition');
    $this->repository->expects($this->once())->method('commit');

    $this->service->moveNews(['id' => 10, 'dir' => 'up']);
  }

  public function testShouldThrowServiceExceptionWhenMoveNewsFailure(): void
  {
    $this->expectException(ServiceException::class);
    $this->repository->expects($this->once())->method('beginTransaction');
    $this->repository->expects($this->once())->method('rollback');

    $this->repository->method('getPost')->willThrowException(new RepositoryException('Błąd'));

    $this->service->moveNews(['id' => 10, 'dir' => 'up']);
  }

  // =========================================================================
  // SECTION: GALLERY
  // =========================================================================

  public function testShouldCreateGalleryAndUploadImage(): void
  {
    // GIVEN
    $fileData = ['tmp_name' => '/tmp/fakephp', 'name' => 'fake.jpg'];
    $inputData = ['image_name' => $fileData, 'title' => 'Test'];
    $uploadedFileName = 'unique_fake.jpg';
    $expectedDbData = ['image_name' => $uploadedFileName, 'title' => 'Test'];

    // EXPECTS
    $this->repository->expects($this->once())->method('beginTransaction');
    $this->fileHandler->expects($this->once())->method('uploadImage')->with($fileData)->willReturn($uploadedFileName);
    $this->repository->expects($this->once())->method('incrementPosition')->with('gallery');
    $this->repository->expects($this->once())->method('addImage')->with($expectedDbData);
    $this->repository->expects($this->once())->method('commit');

    // WHEN 
    $this->service->createGallery($inputData);
  }

  public function testShouldThrowServiceExceptionWhenImageUploaderFailure(): void
  {
    $fileData = ['tmp_name' => '/tmp/fakephp', 'name' => 'fake.jpg'];
    $inputData = ['image_name' => $fileData, 'title' => 'Test'];

    $this->expectException(ServiceException::class);
    $this->expectExceptionMessage('Nie udało się dodać zdjęcia');

    $this->repository->expects($this->once())->method('beginTransaction');
    $this->repository->expects($this->once())->method('rollback');
    $this->fileHandler->method('uploadImage')->willThrowException(new FileException('Błąd'));

    $this->service->createGallery($inputData);
  }

  public function testShouldRollbackWhenNoFileWasUploaded(): void
  {
    $fileData = ['error' => UPLOAD_ERR_NO_FILE];
    $inputData = ['image_name' => $fileData, 'title' => 'Test'];

    $this->expectException(ServiceException::class);
    $this->expectExceptionMessage('Nie udało się dodać zdjęcia');

    $this->repository->expects($this->once())->method('beginTransaction');
    $this->repository->expects($this->once())->method('rollback');
    $this->fileHandler->method('uploadImage')->willThrowException(new FileException('Błąd'));

    $this->service->createGallery($inputData);
  }

  public function testShouldRollbackAndThrowRepositoryExceptionWhenFailsAfterUpload(): void
  {
    $fileData = ['tmp_name' => '/tmp/fakephp', 'name' => 'fake.jpg'];
    $inputData = ['image_name' => $fileData, 'title' => 'Test'];

    $this->expectException(ServiceException::class);
    $this->expectExceptionMessage('Nie udało się dodać zdjęcia');

    $this->repository->expects($this->once())->method('beginTransaction');
    $this->fileHandler->expects($this->once())->method('uploadImage'); // Upload passed
    $this->repository->expects($this->once())->method('rollback');

    $this->repository->method('incrementPosition')->willThrowException(new RepositoryException('Błąd'));

    $this->service->createGallery($inputData);
  }

  public function testShouldGetAllGallery(): void
  {
    $galleryPosts = [['id' => 1, 'title' => 'test']];
    $this->repository->method('getDashboardData')->with('gallery')->willReturn($galleryPosts);
    $this->assertEquals($galleryPosts, $this->service->getAllGallery());
  }

  public function testShouldUpdateGallery(): void
  {
    $data = ['title' => 'Edycja'];
    $this->repository->expects($this->once())->method('edit')->with('gallery', $data);
    $this->service->updateGallery($data);
  }

  public function testShouldPublishGallery(): void
  {
    $data = ['id' => 1, 'status' => 1];
    $this->repository->expects($this->once())->method('published')->with($data, 'gallery');
    $this->service->publishedGallery($data);
  }

  public function testShouldDeleteGalleryAndDecrementPositions(): void
  {
    $id = 1;
    $postData = ['id' => 1, 'position' => 5];

    $this->repository->expects($this->once())->method('beginTransaction');
    $this->repository->expects($this->once())->method('getPost')->with($id, 'gallery')->willReturn($postData);
    $this->repository->expects($this->once())->method('delete')->with($id, 'gallery');
    $this->repository->expects($this->once())->method('decrementPosition')->with('gallery', 5);
    $this->repository->expects($this->once())->method('commit');

    $this->service->deleteGallery($id);
  }

  public function testShouldMoveGalleryUp(): void
  {
    $table = 'gallery';
    $currentPost = ['id' => 10, 'position' => 5];
    $neighborPost  = ['id' => 11, 'position' => 4];

    $this->repository->expects($this->once())->method('beginTransaction');
    $this->repository->expects($this->once())->method('getPost')->with(10, $table)->willReturn($currentPost);
    $this->repository->expects($this->once())->method('getPostByPosition')->with($table, 4)->willReturn($neighborPost);
    $this->repository->expects($this->exactly(2))->method('movePosition');
    $this->repository->expects($this->once())->method('commit');

    $this->service->moveGallery(['id' => 10, 'dir' => 'up']);
  }

  // =========================================================================
  // SECTION: IMPORTANT POSTS
  // =========================================================================

  public function testShouldCreateImportantPost(): void
  {
    $data = ['title' => 'Ważny Post'];
    $this->repository->expects($this->once())->method('beginTransaction');
    $this->repository->expects($this->once())->method('incrementPosition')->with('important_posts');
    $this->repository->expects($this->once())->method('create')->with($data, 'important_posts');
    $this->repository->expects($this->once())->method('commit');
    $this->service->createImportantPost($data);
  }

  public function testShouldGetAllImportantPosts(): void
  {
    $importantPosts = [['id' => 1, 'title' => 'test']];
    $this->repository->method('getDashboardData')->with('important_posts')->willReturn($importantPosts);
    $this->assertEquals($importantPosts, $this->service->getAllImportantPosts());
  }

  public function testShouldUpdateImportantPost(): void
  {
    $data = ['title' => 'Ważne'];
    $this->repository->expects($this->once())->method('edit')->with('important_posts', $data);
    $this->service->updateImportantPost($data);
  }

  public function testShouldPublishImportantPost(): void
  {
    $data = ['id' => 1, 'status' => 1];
    $this->repository->expects($this->once())->method('published')->with($data, 'important_posts');
    $this->service->publishedImportantPost($data);
  }

  public function testShouldDeleteImportantPost(): void
  {
    $id = 1;
    $postData = ['id' => 1, 'position' => 5];

    $this->repository->expects($this->once())->method('beginTransaction');
    $this->repository->expects($this->once())->method('getPost')->with($id, 'important_posts')->willReturn($postData);
    $this->repository->expects($this->once())->method('delete')->with($id, 'important_posts');
    $this->repository->expects($this->once())->method('decrementPosition')->with('important_posts', 5);
    $this->repository->expects($this->once())->method('commit');

    $this->service->deleteImportantPost($id);
  }

  public function testShouldMoveImportantPostUp(): void
  {
    $table = 'important_posts';
    $currentPost = ['id' => 10, 'position' => 5];
    $neighborPost  = ['id' => 11, 'position' => 4];

    $this->repository->expects($this->once())->method('beginTransaction');
    $this->repository->expects($this->once())->method('getPost')->with(10, $table)->willReturn($currentPost);
    $this->repository->expects($this->once())->method('getPostByPosition')->with($table, 4)->willReturn($neighborPost);
    $this->repository->expects($this->exactly(2))->method('movePosition');
    $this->repository->expects($this->once())->method('commit');

    $this->service->moveImportantPost(['id' => 10, 'dir' => 'up']);
  }

  // =========================================================================
  // SECTION: MAIN PAGE POSTS
  // =========================================================================

  public function testShouldCreateMainPagePost(): void
  {
    $data = ['title' => 'Main Post'];
    $this->repository->expects($this->once())->method('beginTransaction');
    $this->repository->expects($this->once())->method('incrementPosition')->with('main_page_posts');
    $this->repository->expects($this->once())->method('create')->with($data, 'main_page_posts');
    $this->repository->expects($this->once())->method('commit');
    $this->service->createMain($data);
  }

  public function testShouldGetAllMainPagePosts(): void
  {
    $mainPosts = [['id' => 1, 'title' => 'test']];
    $this->repository->method('getDashboardData')->with('main_page_posts')->willReturn($mainPosts);
    $this->assertEquals($mainPosts, $this->service->getAllMain());
  }

  public function testShouldUpdateMainPagePost(): void
  {
    $data = ['title' => 'Ważne'];
    $this->repository->expects($this->once())->method('edit')->with('main_page_posts', $data);
    $this->service->updateMain($data);
  }

  public function testShouldPublishMainPagePost(): void
  {
    $data = ['id' => 1, 'status' => 1];
    $this->repository->expects($this->once())->method('published')->with($data, 'main_page_posts');
    $this->service->publishedMain($data);
  }

  public function testShouldDeleteMainPagePost(): void
  {
    $id = 1;
    $postData = ['id' => 1, 'position' => 5];

    $this->repository->expects($this->once())->method('beginTransaction');
    $this->repository->expects($this->once())->method('getPost')->with($id, 'main_page_posts')->willReturn($postData);
    $this->repository->expects($this->once())->method('delete')->with($id, 'main_page_posts');
    $this->repository->expects($this->once())->method('decrementPosition')->with('main_page_posts', 5);
    $this->repository->expects($this->once())->method('commit');

    $this->service->deleteMain($id);
  }

  public function testShouldMoveMainPagePostUp(): void
  {
    $table = 'main_page_posts';
    $currentPost = ['id' => 10, 'position' => 5];
    $neighborPost  = ['id' => 11, 'position' => 4];

    $this->repository->expects($this->once())->method('beginTransaction');
    $this->repository->expects($this->once())->method('getPost')->with(10, $table)->willReturn($currentPost);
    $this->repository->expects($this->once())->method('getPostByPosition')->with($table, 4)->willReturn($neighborPost);
    $this->repository->expects($this->exactly(2))->method('movePosition');
    $this->repository->expects($this->once())->method('commit');

    $this->service->moveMain(['id' => 10, 'dir' => 'up']);
  }

  // =========================================================================
  // SECTION: TIMETABLE
  // =========================================================================

  public function testShouldCreateTimetable(): void
  {
    $data = ['day' => 'poniedziałek'];
    $this->repository->expects($this->once())->method('beginTransaction');
    $this->repository->expects($this->once())->method('incrementPosition')->with('timetable');
    $this->repository->expects($this->once())->method('create')->with($data, 'timetable');
    $this->repository->expects($this->once())->method('commit');
    $this->service->createTimetable($data);
  }

  public function testShouldGetAllTimetable(): void
  {
    $data = [['day' => 'poniedziałek']];
    $this->repository->expects($this->once())->method('timetablePageData')->willReturn($data);
    $this->assertEquals($data, $this->service->getAllTimetable());
  }

  public function testShouldThrowServiceExceptionWhenGetAllTimetableFailure(): void
  {
    $this->expectException(ServiceException::class);
    $this->expectExceptionMessage('Nie udało się pobrać grafiku');
    $this->repository->method('timetablePageData')->willThrowException(new RepositoryException());
    $this->service->getAllTimetable();
  }

  public function testShouldUpdateTimetable(): void
  {
    $data = ['day' => 'wtorek'];
    $this->repository->expects($this->once())->method('edit')->with('timetable', $data);
    $this->service->updateTimetable($data);
  }

  public function testShouldPublishTimetable(): void
  {
    $data = ['id' => 1, 'status' => 1];
    $this->repository->expects($this->once())->method('published')->with($data, 'timetable');
    $this->service->publishedTimetable($data);
  }

  public function testShouldDeleteTimetable(): void
  {
    $id = 1;
    $postData = ['id' => 1, 'position' => 5];

    $this->repository->expects($this->once())->method('beginTransaction');
    $this->repository->expects($this->once())->method('getPost')->with($id, 'timetable')->willReturn($postData);
    $this->repository->expects($this->once())->method('delete')->with($id, 'timetable');
    $this->repository->expects($this->once())->method('decrementPosition')->with('timetable', 5);
    $this->repository->expects($this->once())->method('commit');

    $this->service->deleteTimetable($id);
  }

  public function testShouldMoveTimetableUp(): void
  {
    $table = 'timetable';
    $currentPost = ['id' => 10, 'position' => 5];
    $neighborPost  = ['id' => 11, 'position' => 4];

    $this->repository->expects($this->once())->method('beginTransaction');
    $this->repository->expects($this->once())->method('getPost')->with(10, $table)->willReturn($currentPost);
    $this->repository->expects($this->once())->method('getPostByPosition')->with($table, 4)->willReturn($neighborPost);
    $this->repository->expects($this->exactly(2))->method('movePosition');
    $this->repository->expects($this->once())->method('commit');

    $this->service->moveTimetable(['id' => 10, 'dir' => 'up']);
  }

  // =========================================================================
  // SECTION: SINGLE ROWS (Fees, Camp, Contact)
  // =========================================================================

  public function testShouldGetFeesAndReturnFirstElement(): void
  {
    $fees = [['amount' => 100]];
    $this->repository->expects($this->once())->method('getDashboardData')->with('fees')->willReturn($fees);
    $this->assertEquals(['amount' => 100], $this->service->getFees());
  }

  public function testShouldUpdateFees(): void
  {
    $data = ['amount' => 100];
    $this->repository->expects($this->once())->method('edit')->with('fees', $data);
    $this->service->updateFees($data);
  }

  public function testShouldGetCampAndReturnFirstElement(): void
  {
    $camp = [['city' => 'warszawa']];
    $this->repository->expects($this->once())->method('getDashboardData')->with('camp')->willReturn($camp);
    $this->assertEquals(['city' => 'warszawa'], $this->service->getCamp());
  }

  public function testShouldUpdateCamp(): void
  {
    $data = ['city' => 'warszawa'];
    $this->repository->expects($this->once())->method('edit')->with('camp', $data);
    $this->service->updateCamp($data);
  }

  public function testShouldGetContactAndReturnFirstElement(): void
  {
    $contact = [['email' => 'test@gmail.com']];
    $this->repository->expects($this->once())->method('getDashboardData')->with('contact')->willReturn($contact);
    $this->assertEquals(['email' => 'test@gmail.com'], $this->service->getContact());
  }

  public function testShouldUpdateContact(): void
  {
    $data = ['email' => 'test@gmail.com'];
    $this->repository->expects($this->once())->method('edit')->with('contact', $data);
    $this->service->updateContact($data);
  }
}
