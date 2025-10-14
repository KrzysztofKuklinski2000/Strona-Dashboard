<?php

declare(strict_types=1);

namespace App\Service\Dashboard;

/**
 * Interfejs definiujący operacje wyłącznie dla modułu Aktualności.
 */
interface ImportantPostsManagementServiceInterface
{
  /**
   * Pobiera wszystkie ważnych postów.
   * @return array
   */
  public function getAllImportantPosts(): array;

  /**
   * Aktualizuje istniejący ważnych wpis.
   * @param array $data Nowe dane z formularza.
   * @return void
   */
  public function updateImportantPost(array $data): void;

  /**
   * Tworzy nowy ważnych wpis.
   * @param array $data Dane posta z formularza.
   * @return void
   */
  public function createImportantPost(array $data): void;

  /**
   * Zmienia status publikacji wpisu.
   * @param array $data Dane posta z formularza.
   * @return void
   */
  public function publishedImportantPost(array $data): void;

  /**
   * Usuwa ważnych wpis.
   * @param int $id ID posta do usunięcia.
   * @return void
   */
  public function deleteImportantPost(int $id): void;

  /**
   * Zmienia pozycje wpisu.
   * @param array $data Dane posta z formularza.
   * @return void
   */
  public function moveImportantPost(array $data): void;
}
