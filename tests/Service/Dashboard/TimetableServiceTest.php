<?php

declare(strict_types=1);

namespace Tests\Service\Dashboard;

use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Notification\NotificationService;
use App\Repository\DashboardRepository;
use App\Service\Dashboard\TimetableService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class TimetableServiceTest extends TestCase
{
  private DashboardRepository | MockObject $repository;
  private NotificationService | MockObject $notificationService;
  private TimetableService $service;

  protected function setUp(): void
  {
    $this->repository = $this->createMock(DashboardRepository::class);
    $this->notificationService = $this->createMock(NotificationService::class);
    $this->service = new TimetableService($this->repository, $this->notificationService);
  }

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
    $this->notificationService->expects($this->once())->method('notifyAboutTimetableUpdate');
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
}
