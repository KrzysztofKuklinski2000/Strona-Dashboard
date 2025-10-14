<?php

declare(strict_types=1);

namespace App\Service\Dashboard;

/**
 * Interfejs definiujący operacje wyłącznie dla modułu Aktualności.
 */
interface NewsManagementServiceInterface
{
  /**
   * Pobiera wszystkie wpisy aktualności.
   * @return array
   */
  public function getAllNews(): array;

  /**
   * Aktualizuje istniejący wpis aktualności.
   * @param array $data Nowe dane z formularza.
   * @return void
   */
  public function updateNews(array $data): void;

  /**
   * Tworzy nowy wpis aktualności.
   * @param array $data Dane posta z formularza.
   * @return void
   */
  public function createNews(array $data): void;

  /**
   * Zmienia status publikacji wpisu.
   * @param array $data Dane posta z formularza.
   * @return void
   */
  public function publishedNews(array $data): void;

  /**
   * Usuwa wpis aktualności.
   * @param int $id ID posta do usunięcia.
   * @return void
   */
  public function deleteNews(int $id): void;

  /**
   * Zmienia pozycje wpisu.
   * @param array $data Dane posta z formularza.
   * @return void
   */
  public function moveNews(array $data): void;

}
