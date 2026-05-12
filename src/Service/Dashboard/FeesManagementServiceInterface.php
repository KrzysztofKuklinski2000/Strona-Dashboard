<?php

declare(strict_types=1);

namespace App\Service\Dashboard;

use App\DTO\Dashboard\FeesDto;

/**
 * Interfejs definiujący operacje wyłącznie dla modułu Aktualności.
 */
interface FeesManagementServiceInterface extends SharedGetDataServiceInterface
{
  /**
   * Pobiera wszystkie wpisy opłat.
   * @return DTO object
   */
  public function getFees(): FeesDto;

  /**
   * Aktualizuje istniejący wpis opłat.
   * @param DTO object $data Nowe dane z formularza.
   * @return void
   */
  public function updateFees(FeesDto $feesDto): void;
}
