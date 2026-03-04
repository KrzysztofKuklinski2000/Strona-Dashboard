<?php

namespace App\Service\Dashboard;

class SubscribersService extends AbstractDashboardService implements SubscribersManagementServiceInterface
{
  private const TABLE = 'subscribers';

  public function getAllSubscribers(): array
  {
    return $this->getAll(self::TABLE);
  }
}
