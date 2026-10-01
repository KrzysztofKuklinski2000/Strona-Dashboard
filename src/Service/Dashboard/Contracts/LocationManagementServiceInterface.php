<?php

namespace App\Service\Dashboard\Contracts;

use App\DTO\Dashboard\Location\LocationDto;

interface LocationManagementServiceInterface extends SharedGetDataServiceInterface
{
    /**
     * Pobiera wszystkie lokalizacje zajęć.
     * @return LocationDto[]
     */
    public function getAllLocations(): array;
}