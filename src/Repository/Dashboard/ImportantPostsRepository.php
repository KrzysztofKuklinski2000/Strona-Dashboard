<?php

declare(strict_types=1);

namespace App\Repository\Dashboard;

use App\DTO\Dashboard\ImportantPostsDto;
use App\DTO\DataTransferObjectInterface;
use App\Repository\Dashboard\Traits\CanPublished;
use App\Repository\Dashboard\Traits\Positionable;
use App\Repository\Dashboard\Traits\StandardCrud;

class ImportantPostsRepository extends BaseDashboardRepository
{
    use Positionable;
    use StandardCrud;
    use CanPublished;

    protected function mapToDto(array $data): DataTransferObjectInterface
    {
        return ImportantPostsDto::fromArray($data);
    }
}
