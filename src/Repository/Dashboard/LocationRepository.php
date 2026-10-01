<?php

namespace App\Repository\Dashboard;

use App\DTO\Dashboard\Location\LocationDto;
use App\DTO\DataTransferObjectInterface;
use App\Repository\Dashboard\Traits\CanCreate;

class LocationRepository extends BaseDashboardRepository
{
    use CanCreate;

    protected function mapToDto(array $data): DataTransferObjectInterface
    {
        return LocationDto::fromArray($data);
    }
}