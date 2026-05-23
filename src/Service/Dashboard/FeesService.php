<?php

namespace App\Service\Dashboard;

use App\DTO\Dashboard\FeesDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\ServiceException;
use App\Service\Dashboard\Traits\CanEdit;

class FeesService extends AbstractDashboardService implements FeesManagementServiceInterface
{
    use CanEdit;

    private const TABLE = 'fees';

    /**
     * @throws ServiceException
     */
    public function updateFees(DataTransferObjectInterface $feesDto): void
    {
        $this->edit(self::TABLE, $feesDto);
    }

    /**
     * @throws ServiceException
     */
    public function getFees(): DataTransferObjectInterface
    {
        return $this->getAll(self::TABLE)[0];
    }
}
