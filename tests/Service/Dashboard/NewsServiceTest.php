<?php

declare(strict_types=1);

namespace Tests\Service\Dashboard;

use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Repository\DashboardRepository;
use App\Service\Dashboard\NewsService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class NewsServiceTest extends TestCase
{
  private DashboardRepository | MockObject $repository;
  private NewsService $service;

  protected function setUp(): void
  {
    $this->repository = $this->createMock(DashboardRepository::class);
    $this->service = new NewsService($this->repository);
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
}
