<?php

namespace App\Repository\Dashboard;

use App\DTO\Dashboard\GalleryDto;
use App\DTO\DataTransferObjectInterface;
use App\Repository\Dashboard\Traits\CanCreate;
use App\Repository\Dashboard\Traits\CanDelete;
use App\Repository\Dashboard\Traits\CanEdit;
use App\Repository\Dashboard\Traits\CanPublished;
use App\Repository\Dashboard\Traits\Positionable;

class GalleryRepository extends BaseDashboardRepository
{
    use Positionable, CanPublished, CanEdit, CanDelete, CanCreate;

    protected function mapToDto(array $data): DataTransferObjectInterface
    {
        return GalleryDto::fromArray($data);
    }
}