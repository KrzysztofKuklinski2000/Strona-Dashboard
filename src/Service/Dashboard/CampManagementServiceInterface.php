<?php

declare(strict_types=1);

namespace App\Service\Dashboard;

use App\DTO\Dashboard\CampDto;
use App\DTO\DataTransferObjectInterface;

/**
 * Interfejs definiujący operacje wyłącznie dla modułu Aktualności.
 */
interface CampManagementServiceInterface
{
    /**
     * Pobiera wszystkie wpisy opłat.
     * @return DataTransferObjectInterface
     */
  public function getCamp(): DataTransferObjectInterface;

  /**
   * Aktualizuje istniejący wpis opłat.
   * @param DTO $data Nowe dane z formularza.
   * @return void
   */
  public function updateCamp(DataTransferObjectInterface $campDto): void;
}
