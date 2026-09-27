<?php

namespace App\Service\Dashboard\Contracts;

use App\DTO\Dashboard\GalleryCategory\GalleryCategoryDto;

interface GalleryCategoryManagementServiceInterface
{
    /**
     * Pobiera wszystkie wpisy galerii.
     * @return GalleryCategoryDto[]
     */
    public function getAllCategories(): array;
}