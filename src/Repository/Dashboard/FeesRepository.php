<?php

namespace App\Repository\Dashboard;

use App\DTO\Dashboard\FeesDto;
use App\DTO\DataTransferObjectInterface;
use App\Repository\Dashboard\Traits\CanEdit;

class FeesRepository extends BaseDashboardRepository
{
    use CanEdit;

    protected function mapToDto(array $data): DataTransferObjectInterface
    {
        return FeesDto::fromArray($data);
    }
}