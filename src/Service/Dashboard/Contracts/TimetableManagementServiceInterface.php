<?php

declare(strict_types=1);

namespace App\Service\Dashboard\Contracts;

use App\DTO\Dashboard\CreateTimetableDto;
use App\DTO\Dashboard\PublishedDto;
use App\DTO\Dashboard\TimetableDto;
use App\DTO\Dashboard\UpdateTimetableDto;

/**
 * Interfejs definiujący operacje wyłącznie dla modułu Grafiku.
 */
interface TimetableManagementServiceInterface extends SharedGetDataServiceInterface
{
    /**
     * Pobiera wszystkie wpisy.
     * @return TimetableDto[]
     */
    public function getAllTimetable(): array;

    /**
     * Aktualizuje istniejący wpis.
     * @param UpdateTimetableDto $data
     * @return void
     */
    public function updateTimetable(UpdateTimetableDto $data): void;

    /**
     * Tworzy nowy wpis.
     * @param CreateTimetableDto $data
     * @return void
     */
    public function createTimetable(CreateTimetableDto $data): void;

    /**
     * Zmienia status publikacji.
     * @param PublishedDto $data
     * @return void
     */
    public function publishedTimetable(PublishedDto $data): void;

    /**
     * Usuwa wpis.
     * @param int $id
     * @return void
     */
    public function deleteTimetable(int $id, bool $shouldNotify): void;
}
