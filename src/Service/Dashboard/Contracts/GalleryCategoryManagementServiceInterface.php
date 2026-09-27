<?php
declare(strict_types=1);

namespace App\Service\Dashboard\Contracts;

use App\DTO\Dashboard\GalleryCategory\GalleryCategoryDto;

interface GalleryCategoryManagementServiceInterface extends SharedGetDataServiceInterface
{
    /**
     * Pobiera wszystkie kategorie dla galeri.
     * @return GalleryCategoryDto[]
     */
    public function getAllCategories(): array;
}