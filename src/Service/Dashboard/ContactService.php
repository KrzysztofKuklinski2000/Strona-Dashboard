<?php

namespace App\Service\Dashboard;

class ContactService extends AbstractDashboardService implements ContactManagementServiceInterface {
  private const TABLE = 'contact';

  public function updateContact(array $data): void
  {
    $this->edit(self::TABLE, $data);
  }

  public function getContact(): array
  {
    return $this->getAll(self::TABLE)[0];
  }
}