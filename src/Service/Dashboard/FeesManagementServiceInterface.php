<?php

declare(strict_types=1);

namespace App\Service\Dashboard;

/**
 * Interfejs definiujący operacje wyłącznie dla modułu Aktualności.
 */
interface FeesManagementServiceInterface extends SharedGetDataServiceInterface
{
  /**
   * Pobiera wszystkie wpisy opłat.
   * @return array
   */
  public function getFees(): array;

  /**
   * Aktualizuje istniejący wpis opłat.
   * @param array $data Nowe dane z formularza.
   * @return void
   */
  public function updateFees(array $data): void;
}
