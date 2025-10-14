<?php

declare(strict_types=1);

namespace App\Service\Dashboard;

/**
 * Interfejs definiujący operacje wyłącznie dla modułu Timetable.
 */
interface TimeTableManagementServiceInterface
{
  /**
   * Pobiera wszystkie wpisy.
   * @return array
   */
  public function getAllTimetable(): array;

  /**
   * Aktualizuje istniejący wpis.
   * @param array $data Nowe dane z formularza.
   * @return void
   */
  public function updateTimetable(array $data): void;

  /**
   * Tworzy nowy wpis.
   * @param array $data Dane posta z formularza.
   * @return void
   */
  public function createTimetable(array $data): void;

  /**
   * Zmienia status publikacji.
   * @param array $data Dane posta z formularza.
   * @return void
   */
  public function publishedTimetable(array $data): void;

  /**
   * Usuwa wpis.
   * @param int $id ID posta do usunięcia.
   * @return void
   */
  public function deleteTimetable(int $id): void;

  /**
   * Zmienia pozycje wpisu.
   * @param array $data Dane posta z formularza.
   * @return void
   */
  public function moveTimetable(array $data): void;
}
