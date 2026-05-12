<?php

namespace App\Service\Dashboard;

use App\DTO\Dashboard\FeesDto;
use App\Exception\ServiceException;
use App\Service\Dashboard\Traits\CanEdit;

class FeesService extends AbstractDashboardService implements FeesManagementServiceInterface
{
    use CanEdit;

    private const TABLE = 'fees';

    /**
     * @throws ServiceException
     */
    public function updateFees(FeesDto $feesDto): void
    {
        $this->edit(self::TABLE, $feesDto->toArray());
    }

    /**
     * @throws ServiceException
     */
    public function getFees(): FeesDto
    {
        $data = $this->getAll(self::TABLE)[0];

        return FeesDto::fromArray($data);
    }
}
