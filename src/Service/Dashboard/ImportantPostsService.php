<?php

namespace App\Service\Dashboard;

use App\Exception\ServiceException;

use App\Service\Dashboard\Traits\CanEdit;
use App\Service\Dashboard\Traits\CanPublished;
use App\Service\Dashboard\Traits\PositionableTrait;

class ImportantPostsService extends AbstractDashboardService implements ImportantPostsManagementServiceInterface
{
    use PositionableTrait, CanPublished, CanEdit;
  private const TABLE = 'important_posts';

    /**
     * @throws ServiceException
     */
    public function getAllImportantPosts(): array
  {
    return $this->getAll(self::TABLE);
  }

    /**
     * @throws ServiceException
     */
    public function updateImportantPost(array $data): void
  {
    $this->edit(self::TABLE, $data);
  }

  public function createImportantPost(array $data): void
  {
    $this->create(self::TABLE, $data);
  }

    /**
     * @throws ServiceException
     */
    public function publishedImportantPost(array $data): void
  {
    $this->published(self::TABLE, $data);
  }

  public function deleteImportantPost(int $id): void
  {
    $this->delete(self::TABLE, $id);
  }

  public function moveImportantPost(array $data): void
  {
    $this->move(self::TABLE, $data);
  }
}
