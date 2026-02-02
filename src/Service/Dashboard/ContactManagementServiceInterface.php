<?php

declare(strict_types=1);

namespace App\Service\Dashboard;

/**
 * Interfejs definiujący operacje wyłącznie dla modułu Aktualności.
 */
interface ContactManagementServiceInterface extends SharedGetDataServiceInterface
{
  /**
   * Pobiera wszystkie wpisy opłat.
   * @return array
   */
  public function getContact(): array;

  /**
   * Aktualizuje istniejący wpis opłat.
   * @param array $data Nowe dane z formularza.
   * @return void
   */
  public function updateContact(array $data): void;
}
