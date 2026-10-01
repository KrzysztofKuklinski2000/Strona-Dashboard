<?php

namespace App\Service\Dashboard\Contracts;

use App\DTO\Dashboard\Location\CreateLocationDto;
use App\DTO\Dashboard\Location\LocationDto;
use App\DTO\Dashboard\Location\UpdateLocationDto;

interface LocationManagementServiceInterface extends SharedGetDataServiceInterface
{
    /**
     * Pobiera wszystkie lokalizacje zajęć.
     * @return LocationDto[]
     */
    public function getAllLocations(): array;

    /**
     * Tworzy nową lokalizacje zajęć.
     * @param CreateLocationDto $data
     * @return void
     */
    public function createLocation(CreateLocationDto $data): void;

    /**
     * Aktualizuje lokalizację zajęć.
     * @param UpdateLocationDto $data
     * @return void
     */
    public function updateLocation(UpdateLocationDto $data): void;

    /**
     * Usówanie lokalizację zajęć.
     * @param int $id
     * @return void
     */
    public function deleteLocation(int $id): void;
}