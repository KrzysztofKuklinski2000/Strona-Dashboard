<?php

declare(strict_types=1);

namespace App\Service\Dashboard;

use App\DTO\DataTransferObjectInterface;

/**
 * Interfejs definiujący operacje wyłącznie dla modułu Aktualności.
 */
interface ContactManagementServiceInterface
{
    /**
     * Pobiera wszystkie wpisy opłat.
     * @return DataTransferObjectInterface
     */
  public function getContact(): DataTransferObjectInterface;

    /**
     * Aktualizuje istniejący wpis opłat.
     * @param DataTransferObjectInterface $contactDto
     * @return void
     */
  public function updateContact(DataTransferObjectInterface $contactDto): void;
}
