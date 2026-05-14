<?php

declare(strict_types=1);

namespace App\Service\Dashboard;

use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\Dashboard\GalleryDto;
use App\DTO\Dashboard\UpdatePostDto;
use App\DTO\DataTransferObjectInterface;

/**
 * Interfejs definiujący operacje wyłącznie dla modułu Aktualności.
 */
interface GalleryManagementServiceInterface extends SharedGetDataServiceInterface
{
    /**
     * Pobiera wszystkie wpisy galerii.
     * @return array
     */
  public function getAllGallery(): array;

    /**
     * Aktualizuje istniejący wpis galerii.
     * @param UpdatePostDto $galleryDto
     * @return void
     */
  public function updateGallery(DataTransferObjectInterface $galleryDto): void;

    /**
     * Tworzy nowy wpis galerii.
     * @param GalleryDto $galleryDto
     * @return void
     */
  public function createGallery(DataTransferObjectInterface $galleryDto): void;

    /**
     * Zmienia status publikacji wpisu.
     * @param GalleryDto $galleryDto
     * @return void
     */
  public function publishedGallery(DataTransferObjectInterface $galleryDto): void;

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
