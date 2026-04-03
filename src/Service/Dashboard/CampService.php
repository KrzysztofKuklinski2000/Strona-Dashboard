<?php

namespace App\Service\Dashboard;


use App\Exception\ServiceException;
use App\Service\Dashboard\Traits\CanEdit;

class CampService extends AbstractDashboardService implements CampManagementServiceInterface
{
    use CanEdit;

    private const TABLE = 'camp';

    /**
     * @throws ServiceException
     */
    public function updateCamp(array $data): void
    {
        $this->edit(self::TABLE, $data);
    }

    /**
     * @throws ServiceException
     */
    public function getCamp(): array
    {
        return $this->getAll(self::TABLE)[0];
    }

}
