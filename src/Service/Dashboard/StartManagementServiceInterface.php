<?php

declare(strict_types=1);

namespace App\Service\Dashboard;

/**
 * Interfejs definiujący operacje wyłącznie dla modułu Aktualności.
 */
interface StartManagementServiceInterface extends SharedGetDataServiceInterface
{
  /**
   * Pobiera wszystkie wpisy Strony Głownej.
   * @return array
   */
  public function getAllMain(): array;

  /**
   * Aktualizuje istniejący wpis Strony Głownej.
   * @param array $data Nowe dane z formularza.
   * @return void
   */
  public function updateMain(array $data): void;

  /**
   * Tworzy nowy wpis Strony Głownej.
   * @param array $data Dane posta z formularza.
   * @return void
   */
  public function createMain(array $data): void;

  /**
   * Zmienia status publikacji Strony Głownej.
   * @param array $data Dane posta z formularza.
   * @return void
   */
  public function publishedMain(array $data): void;

  /**
   * Usuwa wpis na Stronie Głownej.
   * @param int $id ID posta do usunięcia.
   * @return void
   */
  public function deleteMain(int $id): void;

  /**
   * Zmienia pozycje posta na Stronie Głownej.
   * @param array $data Dane posta z formularza.
   * @return void
   */
  public function moveMain(array $data): void;
}
