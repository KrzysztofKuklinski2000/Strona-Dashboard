<?php

declare(strict_types=1);

namespace Tests\Service\Dashboard;

use App\Core\FileHandler;
use App\Exception\FileException;
use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Repository\DashboardRepository;
use App\Service\Dashboard\GalleryService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GalleryServiceTest extends TestCase
{
  private DashboardRepository | MockObject $repository;
  private FileHandler | MockObject $fileHandler;
  private GalleryService $service;

  protected function setUp(): void
  {
    $this->repository = $this->createMock(DashboardRepository::class);
    $this->fileHandler = $this->createMock(FileHandler::class);
    $this->service = new GalleryService($this->repository, $this->fileHandler);
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
    $neighborPost = ['id' => 11, 'position' => 4];

    $this->repository->expects($this->once())->method('beginTransaction');
    $this->repository->expects($this->once())->method('getPost')->with(10, $table)->willReturn($currentPost);
    $this->repository->expects($this->once())->method('getPostByPosition')->with($table, 4)->willReturn($neighborPost);
    $this->repository->expects($this->exactly(2))->method('movePosition');
    $this->repository->expects($this->once())->method('commit');

    $this->service->moveGallery(['id' => 10, 'dir' => 'up']);
  }
}
