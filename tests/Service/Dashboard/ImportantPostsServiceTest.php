<?php

declare(strict_types=1);

namespace Tests\Service\Dashboard;

use App\Repository\DashboardRepository;
use App\Service\Dashboard\ImportantPostsService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ImportantPostsServiceTest extends TestCase
{
  private DashboardRepository | MockObject $repository;
  private ImportantPostsService $service;

  protected function setUp(): void
  {
    $this->repository = $this->createMock(DashboardRepository::class);
    $this->service = new ImportantPostsService($this->repository);
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
}
