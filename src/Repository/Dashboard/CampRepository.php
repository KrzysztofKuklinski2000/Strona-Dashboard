<?php

namespace App\Repository\Dashboard;

use App\DTO\Dashboard\CampDto;
use App\DTO\DataTransferObjectInterface;
use App\Repository\Dashboard\Traits\CanEdit;

class CampRepository extends BaseDashboardRepository
{
    use CanEdit;

    protected function mapToDto(array $data): DataTransferObjectInterface
    {
        return CampDto::fromArray($data);
    }
}