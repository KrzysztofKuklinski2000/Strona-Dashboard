<?php

declare(strict_types=1);

namespace App\Service\Dashboard;

/**
 * Interfejs definiujący operacje wyłącznie dla modułu Aktualności.
 */
interface CampManagementServiceInterface extends SharedGetDataServiceInterface
{
  /**
   * Pobiera wszystkie wpisy opłat.
   * @return array
   */
  public function getCamp(): array;

  /**
   * Aktualizuje istniejący wpis opłat.
   * @param array $data Nowe dane z formularza.
   * @return void
   */
  public function updateCamp(array $data): void;
}
