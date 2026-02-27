<?php

declare(strict_types=1);

namespace Tests\Service\Dashboard;

use App\Repository\DashboardRepository;
use App\Service\Dashboard\StartService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class StartServiceTest extends TestCase
{
  private DashboardRepository | MockObject $repository;
  private StartService $service;

  protected function setUp(): void
  {
    $this->repository = $this->createMock(DashboardRepository::class);
    $this->service = new StartService($this->repository);
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
}
