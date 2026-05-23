<?php

namespace App\Service\Dashboard;

use App\DTO\DataTransferObjectInterface;
use App\Exception\ServiceException;
use App\Repository\Dashboard\CampRepository;
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
    public function updateCamp(DataTransferObjectInterface $campDto): void
    {
        $this->edit(self::TABLE, $campDto);
    }

    /**
     * @throws ServiceException
     */
    public function getCamp(): DataTransferObjectInterface
    {
        $data = $this->getAll(self::TABLE);
        return $data[0];
    }
}