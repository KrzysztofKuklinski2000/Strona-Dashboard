<?php

namespace App\Service\Dashboard;

use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Notification\Observer\TimetableObserverInterface;

class TimetableService extends AbstractDashboardService implements TimeTableManagementServiceInterface {

  private const TABLE = 'timetable';
  private array $observers = [];

  public function attach(TimetableObserverInterface $observer): void {
    $this->observers[] = $observer;
  }

  private function notify(): void {
    foreach ($this->observers as $observer) {
      $observer->update();
    }
  }

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
    $this->notify();
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