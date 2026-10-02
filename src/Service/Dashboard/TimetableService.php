<?php

declare(strict_types=1);

namespace App\Service\Dashboard;

use App\DTO\Dashboard\Location\LocationDto;
use App\DTO\Dashboard\PublishedDto;
use App\DTO\Dashboard\Timetable\CreateTimetableDto;
use App\DTO\Dashboard\Timetable\TimetableDto;
use App\DTO\Dashboard\Timetable\UpdateTimetableDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\NotFoundException;
use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Repository\Dashboard\LocationRepository;
use App\Repository\Dashboard\TimetableRepository;
use App\Service\Dashboard\Contracts\TimetableManagementServiceInterface;
use App\Service\Dashboard\Traits\StandardCrudTrait;
use App\Traits\Observable;

/**
 * @property TimetableRepository $repository
 */
class TimetableService extends AbstractDashboardService implements TimetableManagementServiceInterface
{
    use Observable;
    use StandardCrudTrait;

    private const TABLE = 'timetable';

    public function __construct(
        TimetableRepository                 $repository,
        private readonly LocationRepository $locationRepository,
        private readonly array              $notifications,
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
    public function getPost(int $id): DataTransferObjectInterface
    {
        return $this->getRow(self::TABLE, $id);
    }

    /**
     * @throws ServiceException
     * @throws NotFoundException
     */
    public function updateTimetable(UpdateTimetableDto $data): void
    {
        /** @var TimetableDto $timetablePost */
        $timetablePost =  $this->getPost($data->id);

        try {
            /** @var LocationDto $location */
            $location = $this->locationRepository->getPost('locations', $data->locationId);
        } catch (NotFoundException $e) {
            throw new ServiceException(
                'Wybrana lokalizacja już nie istnieje.',
                409,
                $e,
            );
        } catch (RepositoryException $e) {
            throw new ServiceException(
                'Nie udało się pobrać lokalizacji.',
                500,
                $e,
            );
        }

        if($location->status !== 1 && $location->id !== $timetablePost->locationId) {
            throw new ServiceException('Lokalizacja jest nie aktywna', 409);
        }

        $this->handleActionWithNotification(
            $data,
            $this->notifications['timetable_updated'],
            fn(DataTransferObjectInterface $dto) => $this->edit(self::TABLE, $dto)
        );
    }

    /**
     * @throws ServiceException
     * @throws NotFoundException
     */
    public function createTimetable(CreateTimetableDto $data): void
    {
        try {
            /** @var LocationDto $location */
            $location = $this->locationRepository->getPost('locations', $data->locationId);
        } catch (NotFoundException $e) {
            throw new ServiceException(
                'Wybrana lokalizacja już nie istnieje.',
                409,
                $e,
            );
        } catch (RepositoryException $e) {
            throw new ServiceException(
                'Nie udało się pobrać lokalizacji.',
                500,
                $e,
            );
        }

        if($location->status === 0) {
            throw new ServiceException('Lokalizacja jest nie aktywna', 409);
        }


        $this->handleActionWithNotification(
            $data,
            $this->notifications['timetable_created'],
            fn(DataTransferObjectInterface $dto) => $this->create(self::TABLE, $dto)
        );
    }

    /**
     * @throws ServiceException
     */
    public function publishedTimetable(PublishedDto $data): void
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

    private function handleActionWithNotification(
        CreateTimetableDto|UpdateTimetableDto|PublishedDto $data,
        string                                             $message,
        callable                                           $action
    ): void
    {
        $shouldNotify = (bool)($data->isNotify ?? false);

        $action($data);

        if ($shouldNotify) {
            $this->notify($message);
        }
    }

    /**
     * @throws ServiceException
     */
    public function getAllActiveLocations(): array
    {
        try {
            return $this->locationRepository->getActiveLocations();
        }catch (RepositoryException $e){
            throw new ServiceException('Nie udało się pobrać dostępnych lokalizacji', 500, $e);
        }
    }

    /**
     * @throws ServiceException
     */
    public function getAvailableLocations(int $locationId): array
    {
        try {
            $locations = $this->locationRepository->getDashboardData('locations', 'id');

            $availableLocations = [];

            /** @var LocationDto $location */
            foreach ($locations as $location) {
                if ($location->id === $locationId) {
                    $availableLocations[] = $location;
                    continue;
                }

                if ($location->status !== 1) {
                    continue;

                }

                $availableLocations[] = $location;
            }

            return $availableLocations;
        } catch (RepositoryException $e) {
            throw new ServiceException(
                'Nie udało się pobrać dostępnych lokalizacji.',
                500,
                $e,
            );
        }
    }
}
