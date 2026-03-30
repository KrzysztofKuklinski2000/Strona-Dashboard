<?php

namespace App\Service\Dashboard;

use App\Exception\ServiceException;
use App\Service\Dashboard\Traits\CanEdit;
use App\Service\Dashboard\Traits\CanPublished;
use App\Service\Dashboard\Traits\PositionableTrait;

class NewsService extends AbstractDashboardService implements NewsManagementServiceInterface
{
    use PositionableTrait, CanPublished, CanEdit;
  private const TABLE = 'news';

    /**
     * @throws ServiceException
     */
    public function getAllNews(): array
  {
    return $this->getAll(self::TABLE);
  }

    /**
     * @throws ServiceException
     */
    public function updateNews(array $data): void
  {
    $this->edit(self::TABLE, $data);
  }

  public function createNews(array $data): void
  {
    $this->create(self::TABLE, $data);
  }

    /**
     * @throws ServiceException
     */
    public function publishedNews(array $data): void
  {
    $this->published(self::TABLE, $data);
  }

  public function deleteNews(int $id): void
  {
    $this->delete(self::TABLE, $id);
  }

  public function moveNews(array $data): void
  {
    $this->move(self::TABLE, $data);
  }
}
