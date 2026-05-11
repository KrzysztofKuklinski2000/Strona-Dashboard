<?php

namespace App\Service\Dashboard;


use App\DTO\Dashboard\CampDto;
use App\Exception\ServiceException;
use App\Service\Dashboard\Traits\CanEdit;

class CampService extends AbstractDashboardService implements CampManagementServiceInterface
{
    use CanEdit;

    private const TABLE = 'camp';

    /**
     * @throws ServiceException
     */
    public function updateCamp(CampDto $campDto): void
    {
        $this->edit(self::TABLE, $campDto->toArray());
    }

    /**
     * @throws ServiceException
     */
    public function getCamp(): CampDto
    {
        $data = $this->getAll(self::TABLE)[0];

        return CampDto::fromArray($data);
    }

}
