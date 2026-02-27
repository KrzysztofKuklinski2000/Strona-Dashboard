<?php

namespace App\Service\Dashboard;

class StartService extends AbstractDashboardService implements StartManagementServiceInterface
{
  private const TABLE = 'main_page_posts';

  public function getAllMain(): array
  {
    return $this->getAll(self::TABLE);
  }

  public function updateMain(array $data): void
  {
    $this->edit(self::TABLE, $data);
  }

  public function createMain(array $data): void
  {
    $this->create(self::TABLE, $data);
  }

  public function publishedMain(array $data): void
  {
    $this->published(self::TABLE, $data);
  }

  public function deleteMain(int $id): void
  {
    $this->delete(self::TABLE, $id);
  }

  public function moveMain(array $data): void
  {
    $this->move(self::TABLE, $data);
  }
}
