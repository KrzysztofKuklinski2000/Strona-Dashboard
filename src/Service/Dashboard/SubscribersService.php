<?php

namespace App\Service\Dashboard;

class SubscribersService extends AbstractDashboardService implements SubscribersManagementServiceInterface
{
  private const TABLE = 'subscribers';

  public function getAllSubscribers(): array
  {
    return $this->getAll(self::TABLE);
  }

  public function createSubscriber(array $data): void
  {
    $this->create(self::TABLE, $data);
  }

  public function updateSubscriber(array $data): void
  {
    $this->edit(self::TABLE, $data);
  }

  public function deleteSubscriber(int $id): void
  {
    $this->delete(self::TABLE, $id);
  }
}
