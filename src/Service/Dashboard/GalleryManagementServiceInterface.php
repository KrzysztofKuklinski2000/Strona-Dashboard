<?php

declare(strict_types=1);

namespace App\Service\Dashboard;

/**
 * Interfejs definiujący operacje wyłącznie dla modułu Aktualności.
 */
interface GalleryManagementServiceInterface
{
  /**
   * Pobiera wszystkie wpisy galerii.
   * @return array
   */
  public function getAllGallery(): array;

  /**
   * Aktualizuje istniejący wpis galerii.
   * @param array $data Nowe dane z formularza.
   * @return void
   */
  public function updateGallery(array $data): void;

  /**
   * Tworzy nowy wpis galerii.
   * @param array $data Dane posta z formularza.
   * @return void
   */
  public function createGallery(array $data): void;

  /**
   * Zmienia status publikacji wpisu.
   * @param array $data Dane posta z formularza.
   * @return void
   */
  public function publishedGallery(array $data): void;

  /**
   * Usuwa wpis w galerii.
   * @param int $id ID posta do usunięcia.
   * @return void
   */
  public function deleteGallery(int $id): void;

  /**
   * Zmienia pozycje wpisu.
   * @param array $data Dane posta z formularza.
   * @return void
   */
  public function moveGallery(array $data): void;
}
