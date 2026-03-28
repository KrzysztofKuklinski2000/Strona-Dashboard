<?php

namespace App\Service\Dashboard;

use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Repository\Dashboard\TimetableRepository;
use App\Traits\Observable;
use App\Service\Dashboard\Traits\StandardCrudTrait;

class TimetableService extends AbstractDashboardService implements TimetableManagementServiceInterface
{
    use Observable;
    use StandardCrudTrait;

    public function __construct(
        private readonly TimetableRepository $timetableRepository
    ) {
        parent::__construct($timetableRepository);
    }


    private const TABLE = 'timetable';

    /**
     * @throws ServiceException
     */
    private function timetablePageData(): array
    {
        try {
            return $this->timetableRepository->timetablePageData();
        } catch (RepositoryException $e) {
            throw new ServiceException("Nie udało się pobrać grafiku", 500, $e);
        }
    }

    /**
     * @throws ServiceException
     */
    public function getAllTimetable(): array
    {
        return $this->timetablePageData();
    }

    /**
     * @throws ServiceException
     */
    public function updateTimetable(array $data): void
    {
        $this->handleActionWithNotification(
            $data,
            "Wprowadziliśmy zmiany w istniejącym grafiku treningów. Odwiedz strone aby zobaczyć zmiany!",
            function ($cleanData) {

                $this->edit(self::TABLE, $cleanData);
            });
    }

    public function createTimetable(array $data): void
    {
        $this->handleActionWithNotification(
            $data,
            "Do grafiku dodano nowe zajęcia! Sprawdź szczegóły na stronie.",
            function ($cleanData) {

                $this->create(self::TABLE, $cleanData);
            });
    }

    /**
     * @throws ServiceException
     */
    public function publishedTimetable(array $data): void
    {
        $this->handleActionWithNotification(
            $data,
            "Grafik został zaktualizowany. Odwiedz strone aby zobaczyć zmiany!",
            function ($cleanData) {

                $this->published(self::TABLE, $cleanData);
            });
    }

    public function deleteTimetable(int $id, bool $shouldNotify): void
    {

        $this->delete(self::TABLE, $id);

        if ($shouldNotify) {
            $this->notify("Pewne zajęcia zostały usunięte z grafiku. Odwiedz strone aby zobaczyć zmiany!");
        }
    }

    private function handleActionWithNotification(array $data, string $message, callable $action): void
    {
        $shouldNotify = !empty($data['is_notify']);

        unset($data['is_notify']);

        $action($data);

        if ($shouldNotify) {
            $this->notify($message);
        }
    }
}