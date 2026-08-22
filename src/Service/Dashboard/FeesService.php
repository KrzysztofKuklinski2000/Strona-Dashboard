<?php

namespace App\Service\Dashboard;

use App\DTO\Dashboard\FeesDto;
use App\Exception\NotFoundException;
use App\Exception\ServiceException;
use App\Service\Dashboard\Contracts\FeesManagementServiceInterface;
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
        $this->edit(self::TABLE, $feesDto);
    }

    /**
     * @throws ServiceException
     * @throws NotFoundException
     */
    public function getFees(): FeesDto
    {
        $fees = $this->getRow(self::TABLE, 1);

        if (!$fees instanceof FeesDto) {
            throw new ServiceException('Nie udało się pobrać danych o opłatach');
        }

        return $fees;
    }
}
