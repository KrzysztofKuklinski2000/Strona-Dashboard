<?php

namespace App\Service\Dashboard;

class NewsService extends AbstractDashboardService implements NewsManagementServiceInterface
{
  private const TABLE = 'news';

  public function getAllNews(): array
  {
    return $this->getAll(self::TABLE);
  }

  public function updateNews(array $data): void
  {
    $this->edit(self::TABLE, $data);
  }

  public function createNews(array $data): void
  {
    $this->create(self::TABLE, $data);
  }

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
