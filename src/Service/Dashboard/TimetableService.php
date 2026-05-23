<?php

namespace App\Service\Dashboard;

use App\DTO\DataTransferObjectInterface;
use App\Exception\NotFoundException;
use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Repository\Dashboard\TimetableRepository;
use App\Traits\Observable;
use App\Service\Dashboard\Traits\StandardCrudTrait;

/**
 * @property TimetableRepository $repository
 */
class TimetableService extends AbstractDashboardService implements TimetableManagementServiceInterface
{
    use Observable;
    use StandardCrudTrait;

    private const TABLE = 'timetable';

    public function __construct(
        TimetableRepository          $repository,
        private readonly array       $notifications,
    )
    {
        parent::__construct($repository);
    }

    /**
     * @throws ServiceException
     */
    public function getAllTimetable(): array
    {
        try {
            return $this->repository->timetablePageData();
        } catch (RepositoryException $e) {
            throw new ServiceException("Nie udało się pobrać grafiku", 500, $e);
        }
    }

    /**
     * @throws ServiceException
     * @throws NotFoundException
     */
    public function getPost(string $table, int $id): ?DataTransferObjectInterface
    {
        return $this->getRow($table, $id);
    }

    /**
     * @throws ServiceException
     */
    public function updateTimetable(DataTransferObjectInterface $data): void
    {
        $this->handleActionWithNotification(
            $data,
            $this->notifications['timetable_updated'],
            fn(DataTransferObjectInterface $dto) => $this->edit(self::TABLE, $dto)
        );
    }

    /**
     * @throws ServiceException
     */
    public function createTimetable(DataTransferObjectInterface $data): void
    {
        $this->handleActionWithNotification(
            $data,
            $this->notifications['timetable_created'],
            fn(DataTransferObjectInterface $dto) => $this->create(self::TABLE, $dto)
        );
    }

    /**
     * @throws ServiceException
     */
    public function publishedTimetable(DataTransferObjectInterface $data): void
    {
        $this->handleActionWithNotification(
            $data,
            $this->notifications['timetable_published'],
            fn(DataTransferObjectInterface $dto) => $this->published(self::TABLE, $dto)
        );
    }

    public function deleteTimetable(int $id, bool $shouldNotify): void
    {
        $this->delete(self::TABLE, $id);

        if ($shouldNotify) {
            $this->notify($this->notifications['timetable_deleted']);
        }
    }

    private function handleActionWithNotification(DataTransferObjectInterface $data, string $message, callable $action): void
    {
        $shouldNotify = (bool) ($data->isNotify ?? false);

        $action($data);

        if ($shouldNotify) {
            $this->notify($message);
        }
    }
}