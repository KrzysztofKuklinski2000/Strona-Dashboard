<?php
declare(strict_types=1);

namespace App\Service\Dashboard\Contracts;

use App\DTO\Dashboard\GalleryCategory\CreateGalleryCategoryDto;
use App\DTO\Dashboard\GalleryCategory\GalleryCategoryDto;

interface GalleryCategoryManagementServiceInterface extends SharedGetDataServiceInterface
{
    /**
     * Pobiera wszystkie kategorie dla galeri.
     * @return GalleryCategoryDto[]
     */
    public function getAllCategories(): array;

    /**
     * Tworzy nową kategorię.
     * @param CreateGalleryCategoryDto $data
     * @return void
     */
    public function createGalleryCategory(CreateGalleryCategoryDto $data): void;

    /**
     * Sprawdza czy istnieje w bazie kategoria z takim samym slug.
     * @param string $slug
     * @return bool
     */
    public function existsBySlug(string $slug): bool;
}