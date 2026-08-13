<?php

declare(strict_types=1);

namespace App\Service\Dashboard\Contracts;

use App\DTO\Dashboard\FeesDto;

/**
 * Interfejs definiujący operacje wyłącznie dla modułu Opłat.
 */
interface FeesManagementServiceInterface
{
    /**
     * Pobiera wszystkie wpisy opłat.
     * @return FeesDto
     */
    public function getFees(): FeesDto;

    /**
     * Aktualizuje istniejący wpis opłat.
     * @param FeesDto $feesDto
     * @return void
     */
    public function updateFees(FeesDto $feesDto): void;
}
