<?php

declare(strict_types=1);

namespace App\Service\Dashboard\Contracts;

use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\Dashboard\Gallery\CreateGalleryDto;
use App\DTO\Dashboard\Gallery\GalleryDto;
use App\DTO\Dashboard\Gallery\UpdateGalleryDto;
use App\DTO\Dashboard\PublishedDto;

interface GalleryManagementServiceInterface extends SharedGetDataServiceInterface
{
    /**
     * Pobiera wszystkie wpisy galerii.
     * @return GalleryDto[]
     */
    public function getAllGallery(): array;

    /**
     * Aktualizuje istniejący wpis galerii.
     * @param UpdateGalleryDto $galleryDto
     * @return void
     */
    public function updateGallery(UpdateGalleryDto $galleryDto): void;

    /**
     * Tworzy nowy wpis galerii.
     * @param CreateGalleryDto $galleryDto
     * @return void
     */
    public function createGallery(CreateGalleryDto $galleryDto): void;

    /**
     * Zmienia status publikacji wpisu.
     * @param PublishedDto $galleryDto
     * @return void
     */
    public function publishedGallery(PublishedDto $galleryDto): void;

    /**
     * Usuwa wpis w galerii.
     * @param int $id ID posta do usunięcia.
     * @return void
     */
    public function deleteGallery(int $id): void;

    /**
     * Zmienia pozycje wpisu.
     * @param ChangePositionDto $changePositionDto
     * @return void
     */
    public function moveGallery(ChangePositionDto $changePositionDto): void;
}
