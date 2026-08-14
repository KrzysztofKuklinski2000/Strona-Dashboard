<?php

namespace App\Repository\Dashboard;

use App\DTO\Dashboard\HomepagePostDto;
use App\DTO\DataTransferObjectInterface;
use App\Repository\Dashboard\Traits\CanPublished;
use App\Repository\Dashboard\Traits\Positionable;
use App\Repository\Dashboard\Traits\StandardCrud;

class HomepageRepository extends BaseDashboardRepository
{
    use Positionable, StandardCrud, CanPublished;

    protected function mapToDto(array $data): DataTransferObjectInterface
    {
        return HomepagePostDto::fromArray($data);
    }
}