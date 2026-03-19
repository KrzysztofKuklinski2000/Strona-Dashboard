<?php

declare(strict_types=1);

namespace Tests\Service\Dashboard;

use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Notification\Observer\TimetableObserverInterface;
use App\Repository\DashboardRepository;
use App\Service\Dashboard\TimetableService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class TimetableServiceTest extends TestCase
{
  private DashboardRepository | MockObject $repository;
  private TimetableService $service;
  private TimetableObserverInterface | MockObject $observer;

  protected function setUp(): void
  {
    $this->repository = $this->createMock(DashboardRepository::class);
    $this->service = new TimetableService($this->repository);

    $this->observer = $this->createMock(TimetableObserverInterface::class);
    $this->service->attach($this->observer);
  }

  public function testShouldUpdateTimetableWithNotification(): void
  {
    // GIVEN
    $data = ['id' => 1, 'day' => 'wtorek', 'is_notify' => true];
    $expectedRepoData = ['id' => 1, 'day' => 'wtorek'];

    // EXPECTS
    $this->observer->expects($this->once())->method('update');
    $this->repository->expects($this->once())->method('edit')->with('timetable', $expectedRepoData);

    // WHEN
    $this->service->updateTimetable($data);
  }

  public function testShouldUpdateTimetableWithoutNotification(): void
  {
    // GIVEN
    $data = ['id' => 1, 'day' => 'wtorek', 'is_notify' => false];
    $expectedRepoData = ['id' => 1, 'day' => 'wtorek'];

    // EXPECTS
    $this->observer->expects($this->never())->method('update');
    $this->repository->expects($this->once())->method('edit')->with('timetable', $expectedRepoData);

    // WHEN
    $this->service->updateTimetable($data);
  }

  public function testShouldCreateTimetableAndNotify(): void
  {
    // GIVEN
    $data = ['day' => 'poniedziałek', 'is_notify' => true];
    $expectedRepoData = ['day' => 'poniedziałek'];

    // EXPECTS
    $this->observer->expects($this->once())->method('update');
    $this->repository->expects($this->once())->method('beginTransaction');
    $this->repository->expects($this->once())->method('incrementPosition')->with('timetable');
    $this->repository->expects($this->once())->method('create')->with($expectedRepoData, 'timetable');
    $this->repository->expects($this->once())->method('commit');

    // WHEN
    $this->service->createTimetable($data);
  }

  public function testShouldNotSendNotificationWhenCheckboxIsNotCheckedAndActionIsCreateTimetable(): void 
  {
    // GIVEN 
    $data = ['day' => 'poniedziałek', 'is_notify' => false];
    $expectedRepoData = ['day' => 'poniedziałek'];

    // EXPECTS
    $this->observer->expects($this->never())->method('update');
    $this->repository->expects($this->once())->method('beginTransaction');
    $this->repository->expects($this->once())->method('incrementPosition')->with('timetable');
    $this->repository->expects($this->once())->method('create')->with($expectedRepoData, 'timetable');
    $this->repository->expects($this->once())->method('commit');

    // WHEN
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

  public function testShouldPublishTimetableAndNotify(): void
  {
    // GIVEN
    $data = ['id' => 1, 'status' => 1, 'is_notify' => true];
    $expectedRepoData = ['id' => 1, 'status' => 1];

    // EXPECTS
    $this->observer->expects($this->once())->method('update');
    $this->repository->expects($this->once())->method('published')->with($expectedRepoData, 'timetable');

    // WHEN
    $this->service->publishedTimetable($data);
  }
  public function testShouldDeleteTimetableWithNotification(): void
  {
    // GIVEN
    $id = 1;
    $shouldNotify = true;
    $postData = ['id' => 1, 'position' => 5];

    // EXPECTS
    $this->observer->expects($this->once())->method('update');
    $this->repository->expects($this->once())->method('beginTransaction');
    $this->repository->expects($this->once())->method('getPost')->with($id, 'timetable')->willReturn($postData);
    $this->repository->expects($this->once())->method('delete')->with($id, 'timetable');
    $this->repository->expects($this->once())->method('decrementPosition')->with('timetable', 5);
    $this->repository->expects($this->once())->method('commit');

    // WHEN
    $this->service->deleteTimetable($id, $shouldNotify);
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
