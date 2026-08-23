<?php

declare(strict_types=1);

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
    use Positionable;
    use CanPublished;
    use CanEdit;
    use CanDelete;
    use CanCreate;

    protected function mapToDto(array $data): DataTransferObjectInterface
    {
        return GalleryDto::fromArray($data);
    }
}
