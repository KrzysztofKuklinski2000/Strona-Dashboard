<?php

namespace App\Service\Dashboard;

use App\DTO\Dashboard\CampDto;
use App\Exception\ServiceException;
use App\Repository\Dashboard\CampRepository;
use App\Service\Dashboard\Contracts\CampManagementServiceInterface;
use App\Service\Dashboard\Traits\CanEdit;

/**
 * @property CampRepository $repository
 */
class CampService extends AbstractDashboardService implements CampManagementServiceInterface
{
    use CanEdit;

    private const TABLE = 'camp';

    /**
     * @throws ServiceException
     */
    public function updateCamp(CampDto $campDto): void
    {
        $this->edit(self::TABLE, $campDto);
    }

    /**
     * @throws ServiceException
     */
    public function getCamp(): CampDto
    {
        $camp = $this->getAll(self::TABLE)[0] ?? null;

        if (!$camp instanceof CampDto) {
            throw new ServiceException('Nie udało się pobrać danych obozu.');
        }

        return $camp;
    }
}