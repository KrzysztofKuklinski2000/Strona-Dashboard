<?php

namespace App\Service\Dashboard;

use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Notification\NotificationService;
use App\Repository\DashboardRepository;

class TimetableService extends AbstractDashboardService implements TimeTableManagementServiceInterface {

  public function __construct(
    DashboardRepository $repository,
    private NotificationService $notificationService
  ){
    parent::__construct($repository);
  }

  private const TABLE = 'timetable';

  private function timetablePageData(): array
  {
    try {
      return $this->repository->timetablePageData();
    } catch (RepositoryException $e) {
      throw new ServiceException("Nie udało się pobrać grafiku", 500, $e);
    }
  }

  public function getAllTimetable(): array
  {
    return $this->timetablePageData();
  }

  public function updateTimetable(array $data): void
  {
    $this->edit(self::TABLE, $data);
    $this->notificationService->notifyAboutTimetableUpdate();
  }

  public function createTimetable(array $data): void
  {
    $this->create(self::TABLE, $data);
  }

  public function publishedTimetable(array $data): void
  {
    $this->published(self::TABLE, $data);
  }

  public function deleteTimetable(int $id): void
  {
    $this->delete(self::TABLE, $id);
  }

  public function moveTimetable(array $data): void
  {
    $this->move(self::TABLE, $data);
  }
}