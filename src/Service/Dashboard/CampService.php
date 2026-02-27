<?php 

namespace App\Service\Dashboard;


class CampService extends AbstractDashboardService implements CampManagementServiceInterface {
  private const TABLE = 'camp';

  public function updateCamp(array $data): void
  {
    $this->edit(self::TABLE, $data);
  }

  public function getCamp(): array
  {
    return $this->getAll(self::TABLE)[0];
  }

}
