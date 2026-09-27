<?php
declare(strict_types=1);

namespace App\Service\Dashboard\Contracts;

use App\DTO\Dashboard\GalleryCategory\CreateGalleryCategoryDto;
use App\DTO\Dashboard\GalleryCategory\GalleryCategoryDto;
use App\DTO\Dashboard\GalleryCategory\UpdateGalleryCategoryDto;

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
     * Aktualizuje nową kategorię.
     * @param UpdateGalleryCategoryDto $data
     * @return void
     */
    public function updateGalleryCategory(UpdateGalleryCategoryDto $data): void;
    /**
     * Usuwa kategorię
     * @param int $id
     */

    public function deleteGalleryCategory(int $id): void;

    /**
     * Sprawdza, czy istnieje w bazie kategoria z takim samym slug.
     * @param string $slug
     * @param int|null $excludedId
     * @return bool
     */
    public function existsBySlug(string $slug, ?int $excludedId = null): bool;
}