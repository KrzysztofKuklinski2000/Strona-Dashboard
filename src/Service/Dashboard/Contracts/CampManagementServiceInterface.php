<?php

declare(strict_types=1);

namespace App\Service\Dashboard\Contracts;

use App\DTO\Dashboard\CampDto;

/**
 * Interfejs definiujący operacje wyłącznie dla modułu Obozu.
 */
interface CampManagementServiceInterface
{
    /**
     * Pobiera wszystkie wpisy Obozu.
     * @return CampDto
     */
    public function getCamp(): CampDto;

    /**
     * Aktualizuje istniejący wpis Obozu.
     * @param CampDto $campDto
     * @return void
     */
    public function updateCamp(CampDto $campDto): void;
}
