<?php

namespace App\Service\Dashboard;

use App\Exception\ServiceException;
use App\Service\Dashboard\Traits\CanEdit;

class FeesService extends AbstractDashboardService implements FeesManagementServiceInterface
{
    use CanEdit;

    private const TABLE = 'fees';

    /**
     * @throws ServiceException
     */
    public function updateFees(array $data): void
    {
        $this->edit(self::TABLE, $data);
    }

    /**
     * @throws ServiceException
     */
    public function getFees(): array
    {
        return $this->getAll(self::TABLE)[0];
    }
}
