<?php

declare(strict_types=1);

namespace App\Service\Dashboard\Contracts;

use App\DTO\Dashboard\Location\LocationDto;
use App\DTO\Dashboard\PublishedDto;
use App\DTO\Dashboard\Timetable\CreateTimetableDto;
use App\DTO\Dashboard\Timetable\TimetableDto;
use App\DTO\Dashboard\Timetable\UpdateTimetableDto;
use App\DTO\Notification\NotificationReportDto;

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
     * Pobiera wszystkie aktywne lokacje + przypisaną wcześniej.
     * @return LocationDto[]
     */
    public function getAvailableLocations(int $locationId): array;

    /**
     * Pobiera wszystkie aktywne lokalizacje.
     * @return LocationDto[]
     */
    public function getAllActiveLocations(): array;
    /**
     * Aktualizuje istniejący wpis.
     * @param UpdateTimetableDto $data
     * @return NotificationReportDto | null
     */
    public function updateTimetable(UpdateTimetableDto $data): ?NotificationReportDto;

    /**
     * Tworzy nowy wpis.
     * @param CreateTimetableDto $data
     * @return NotificationReportDto | null
     */
    public function createTimetable(CreateTimetableDto $data): ?NotificationReportDto;

    /**
     * Zmienia status publikacji.
     * @param PublishedDto $data
     * @return NotificationReportDto | null
     */
    public function publishedTimetable(PublishedDto $data): ?NotificationReportDto;

    /**
     * Usuwa wpis.
     * @param int $id
     * @return NotificationReportDto | null
     */
    public function deleteTimetable(int $id, bool $shouldNotify): ?NotificationReportDto;
}
