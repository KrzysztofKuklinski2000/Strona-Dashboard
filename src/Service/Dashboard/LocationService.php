<?php

namespace App\Service\Dashboard;

use App\DTO\Dashboard\Location\CreateLocationDto;
use App\DTO\Dashboard\Location\UpdateLocationDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\NotFoundException;
use App\Exception\ServiceException;
use App\Service\Dashboard\Contracts\LocationManagementServiceInterface;
use App\Service\Dashboard\Traits\CanCreate;
use App\Service\Dashboard\Traits\CanDelete;
use App\Service\Dashboard\Traits\CanEdit;

class LocationService extends AbstractDashboardService implements LocationManagementServiceInterface
{
    use CanCreate;
    use CanEdit;
    use CanDelete;

    const TABLE = 'locations';

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
}