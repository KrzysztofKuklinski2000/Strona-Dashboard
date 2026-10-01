<?php

namespace App\Repository\Dashboard;

use App\DTO\Dashboard\Location\LocationDto;
use App\DTO\DataTransferObjectInterface;

class LocationRepository extends BaseDashboardRepository
{

    protected function mapToDto(array $data): DataTransferObjectInterface
    {
        return LocationDto::fromArray($data);
    }
}