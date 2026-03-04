<?php

declare(strict_types=1);

namespace App\Service\Dashboard;

/**
 * Interfejs definiujący operacje wyłącznie dla modułu Subscribers.
 */
interface SubscribersManagementServiceInterface extends SharedGetDataServiceInterface
{
  /**
   * Pobiera wszystkich subskrybentów.
   * @return array
   */
  public function getAllSubscribers(): array;
}
