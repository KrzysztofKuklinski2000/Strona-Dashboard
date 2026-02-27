<?php

namespace App\Service\Dashboard;

class ImportantPostsService extends AbstractDashboardService implements ImportantPostsManagementServiceInterface
{
  private const TABLE = 'important_posts';

  public function getAllImportantPosts(): array
  {
    return $this->getAll(self::TABLE);
  }

  public function updateImportantPost(array $data): void
  {
    $this->edit(self::TABLE, $data);
  }

  public function createImportantPost(array $data): void
  {
    $this->create(self::TABLE, $data);
  }

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
