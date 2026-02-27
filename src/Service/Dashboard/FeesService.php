<?php

namespace App\Service\Dashboard;

class FeesService extends AbstractDashboardService implements FeesManagementServiceInterface
{
  private const TABLE = 'fees';

  public function updateFees(array $data): void
  {
    $this->edit(self::TABLE, $data);
  }

  public function getFees(): array
  {
    return $this->getAll(self::TABLE)[0];
  }
}
