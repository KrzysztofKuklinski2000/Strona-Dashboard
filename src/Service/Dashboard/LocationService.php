<?php

namespace App\Service\Dashboard;

use App\Exception\ServiceException;
use App\Service\Dashboard\Contracts\LocationManagementServiceInterface;

class LocationService extends AbstractDashboardService implements LocationManagementServiceInterface
{
    const TABLE = 'locations';

    /**
     * @throws ServiceException
     */
    public function getAllLocations(): array {
        return $this->getAll(table:self::TABLE, orderBy: 'created_at');
    }
}