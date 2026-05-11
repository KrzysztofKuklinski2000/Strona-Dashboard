<?php

declare(strict_types=1);

namespace App\Service\Dashboard;

use App\DTO\Dashboard\CampDto;

/**
 * Interfejs definiujący operacje wyłącznie dla modułu Aktualności.
 */
interface CampManagementServiceInterface
{
  /**
   * Pobiera wszystkie wpisy opłat.
   * @return array
   */
  public function getCamp(): CampDto;

  /**
   * Aktualizuje istniejący wpis opłat.
   * @param DTO $data Nowe dane z formularza.
   * @return void
   */
  public function updateCamp(CampDto $campDto): void;
}
