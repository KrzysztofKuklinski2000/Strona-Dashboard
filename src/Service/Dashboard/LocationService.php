<?php

namespace App\Service\Dashboard;

use App\DTO\Dashboard\Location\CreateLocationDto;
use App\DTO\Dashboard\Location\UpdateLocationDto;
use App\DTO\Dashboard\PublishedDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\NotFoundException;
use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Repository\Dashboard\LocationRepository;
use App\Repository\Dashboard\TimetableRepository;
use App\Service\Dashboard\Contracts\LocationManagementServiceInterface;
use App\Service\Dashboard\Traits\CanCreate;
use App\Service\Dashboard\Traits\CanDelete;
use App\Service\Dashboard\Traits\CanEdit;
use App\Service\Dashboard\Traits\CanPublished;

class LocationService extends AbstractDashboardService implements LocationManagementServiceInterface
{
    use CanCreate;
    use CanEdit;
    use CanDelete;
    use CanPublished;

    const TABLE = 'locations';

    public function __construct(
        LocationRepository $repository,
        private readonly TimetableRepository $timetableRepository,
    )
    {
        parent::__construct($repository);
    }

    /**
     * @throws ServiceException
     */
    public function getAllLocations(): array
    {
        return $this->getAll(table: self::TABLE, orderBy: 'id', orderDir: 'DESC');
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
     */
    public function createLocation(CreateLocationDto $data): void
    {
        $this->create(self::TABLE, $data);
    }

    /**
     * @throws ServiceException
     */
    public function updateLocation(UpdateLocationDto $data): void
    {

        $this->edit(self::TABLE, $data);
    }

    /**
     * @throws ServiceException
     */
    public function deleteLocation(int $id): void
    {
        if ($this->repository->isUsedByTimetable($id)) {
            throw new ServiceException(
                'Nie można usunąć lokalizacji przypisanej do zajęć.',
                409,
            );
        }

        $this->delete(self::TABLE, $id);
    }

    /**
     * @throws ServiceException
     */
    public function publishedLocation(PublishedDto $data): void
    {
        $this->published(self::TABLE, $data);
    }

    /**
     * @throws ServiceException
     */
    public function getTimetableByLocationId(int $id): array {
        try {
            return $this->timetableRepository->getByLocationId($id);
        } catch (RepositoryException $e) {
            throw new ServiceException('Nie udało się pobrać informacji na temat zajęć. ', 500, $e);
        }
    }
}