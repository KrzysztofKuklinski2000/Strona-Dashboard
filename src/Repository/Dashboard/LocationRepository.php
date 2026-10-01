<?php

namespace App\Repository\Dashboard;

use App\DTO\Dashboard\Location\LocationDto;
use App\DTO\DataTransferObjectInterface;
use App\Repository\Dashboard\Traits\CanCreate;
use App\Repository\Dashboard\Traits\CanEdit;

class LocationRepository extends BaseDashboardRepository
{
    use CanCreate;
    use CanEdit;

    protected function mapToDto(array $data): DataTransferObjectInterface
    {
        return LocationDto::fromArray($data);
    }
}