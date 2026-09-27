<?php
declare(strict_types=1);

namespace App\Repository\Dashboard;

use App\DTO\Dashboard\GalleryCategory\GalleryCategoryDto;
use App\DTO\DataTransferObjectInterface;

class GalleryCategoryRepository extends BaseDashboardRepository
{

    protected function mapToDto(array $data): DataTransferObjectInterface
    {
       return GalleryCategoryDto::fromArray($data);
    }
}