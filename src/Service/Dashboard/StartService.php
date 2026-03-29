<?php

namespace App\Service\Dashboard;

use App\Exception\ServiceException;
use App\Service\Dashboard\Traits\CanEdit;
use App\Service\Dashboard\Traits\CanPublished;
use App\Service\Dashboard\Traits\PositionableTrait;

class StartService extends AbstractDashboardService implements StartManagementServiceInterface
{
    use CanPublished, CanEdit, PositionableTrait;
  private const TABLE = 'main_page_posts';

    /**
     * @throws ServiceException
     */
    public function getAllMain(): array
  {
    return $this->getAll(self::TABLE);
  }

    /**
     * @throws ServiceException
     */
    public function updateMain(array $data): void
  {
    $this->edit(self::TABLE, $data);
  }

  public function createMain(array $data): void
  {
    $this->create(self::TABLE, $data);
  }

    /**
     * @throws ServiceException
     */
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
