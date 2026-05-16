<?php

namespace App\Service\Dashboard;

use App\Core\Config;
use App\DTO\Dashboard\TimetableDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\NotFoundException;
use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Repository\Dashboard\TimetableRepository;
use App\Traits\Observable;
use App\Service\Dashboard\Traits\StandardCrudTrait;

class TimetableService extends AbstractDashboardService implements TimetableManagementServiceInterface
{
    use Observable;
    use StandardCrudTrait;

    private const TABLE = 'timetable';

    public function __construct(
        private readonly TimetableRepository $timetableRepository,
        private readonly array               $notifications,
    )
    {
        parent::__construct($timetableRepository);
    }

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
        return array_map(fn(array $row) => TimetableDto::fromArray($row), $this->timetablePageData());
    }

    /**
     * @throws ServiceException
     * @throws NotFoundException
     */
    public function getPost(string $table, int $id): ?DataTransferObjectInterface
    {
        return TimetableDto::fromArray($this->getRow($table, $id));
    }

    /**
     * @throws ServiceException
     */
    public function updateTimetable(DataTransferObjectInterface $data): void
    {
        $this->handleActionWithNotification(
            $data->toArray(),
            $this->notifications['timetable_updated'],
            function ($cleanData) {
                $this->edit(self::TABLE, $cleanData);
            });
    }

    /**
     * @throws ServiceException
     */
    public function createTimetable(DataTransferObjectInterface $data): void
    {
        $this->handleActionWithNotification(
            $data->toArray(),
            $this->notifications['timetable_created'],
            function ($cleanData) {

                $this->create(self::TABLE, $cleanData);
            });
    }

    /**
     * @throws ServiceException
     */
    public function publishedTimetable(DataTransferObjectInterface $data): void
    {
        $this->handleActionWithNotification(
            $data->toArray(),
            $this->notifications['timetable_published'],
            function ($cleanData) {

                $this->published(self::TABLE, $cleanData);
            });
    }

    public function deleteTimetable(int $id, bool $shouldNotify): void
    {

        $this->delete(self::TABLE, $id);

        if ($shouldNotify) {
            $this->notify($this->notifications['timetable_deleted']);
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