<?php

namespace App\Service\Dashboard;

use App\Exception\ServiceException;
use Exception;

class SubscribersService extends AbstractDashboardService implements SubscribersManagementServiceInterface
{
  private const TABLE = 'subscribers';

  public function getAllSubscribers(): array
  {
    return $this->getAll(self::TABLE);
  }

  public function createSubscriber(array $data): string
  {
    $token = bin2hex(random_bytes(32));
    $data['token'] = $token;

    if(!isset($data['is_active'])) {
      $data['is_active'] = 0;
    }

    $this->create(self::TABLE, $data);

    return $token;
  }

  public function updateSubscriber(array $data): void
  {
    $this->edit(self::TABLE, $data);
  }

  public function deleteSubscriber(int $id): void
  {
    $this->delete(self::TABLE, $id);
  }

  public function activateSubscriber(string $token): void {
    $subscriber = $this->repository->getSubscriberByToken(self::TABLE, $token);

    if (!$subscriber) {
        throw new ServiceException("Nieprawidłowy lub wygasły token.", 404);
    }
    $this->edit(self::TABLE, [
      'id' => $subscriber['id'],
      'is_active' => 1,
      'token' => null
    ]);
  }
}
