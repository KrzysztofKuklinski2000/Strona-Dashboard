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

  /**
   * Tworzy nowych subskrybenta .
   * @param array $data Dane posta z formularza.
   * @return void
   */
  public function createSubscriber(array $data): void;

  /**
   * Aktualizuje dane subskrybenta.
   * @param array $data Nowe dane z formularza.
   * @return void
   */
  public function updateSubscriber(array $data): void;

  /**
   * Usuwa subskrybenta.
   * @param int $id ID subskrybenta do usunięcia.
   * @return void
   */
  public function deleteSubscriber(int $id): void;
}
