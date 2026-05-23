<?php

declare(strict_types=1);

namespace App\Service\Dashboard;

use App\DTO\DataTransferObjectInterface;

/**
 * Interfejs definiujący operacje wyłącznie dla modułu Aktualności.
 */
interface FeesManagementServiceInterface
{
  /**
   * Pobiera wszystkie wpisy opłat.
   * @return DataTransferObjectInterface object
   */
  public function getFees(): DataTransferObjectInterface;

  /**
   * Aktualizuje istniejący wpis opłat.
   * @param DataTransferObjectInterface $feesDto object $data Nowe dane z formularza.
   * @return void
   */
  public function updateFees(DataTransferObjectInterface $feesDto): void;
}
