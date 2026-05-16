<?php

declare(strict_types=1);

namespace App\Service\Dashboard;

use App\DTO\DataTransferObjectInterface;

/**
 * Interfejs definiujący operacje wyłącznie dla modułu Timetable.
 */
interface TimetableManagementServiceInterface extends SharedGetDataServiceInterface
{
  /**
   * Pobiera wszystkie wpisy.
   * @return array
   */
  public function getAllTimetable(): array;

    /**
     * Aktualizuje istniejący wpis.
     * @param DataTransferObjectInterface $data Nowe dane z formularza.
     * @return void
     */
  public function updateTimetable(DataTransferObjectInterface $data): void;

    /**
     * Tworzy nowy wpis.
     * @param DataTransferObjectInterface $data Dane posta z formularza.
     * @return void
     */
  public function createTimetable(DataTransferObjectInterface $data): void;

    /**
     * Zmienia status publikacji.
     * @param DataTransferObjectInterface $data Dane posta z formularza.
     * @return void
     */
  public function publishedTimetable(DataTransferObjectInterface $data): void;

  /**
   * Usuwa wpis.
   * @param int $id ID posta do usunięcia.
   * @return void
   */
  public function deleteTimetable(int $id, bool $shouldNotify): void;
}
