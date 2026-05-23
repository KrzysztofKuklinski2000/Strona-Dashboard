<?php

namespace App\Service\Dashboard;

use App\DTO\DataTransferObjectInterface;
use App\Exception\ServiceException;
use App\Repository\Dashboard\ContactRepository;
use App\Service\Dashboard\Traits\CanEdit;

/**
 * @property ContactRepository $repository
 */
class ContactService extends AbstractDashboardService implements ContactManagementServiceInterface
{
    use CanEdit;

    private const TABLE = 'contact';

    /**
     * @throws ServiceException
     */
    public function updateContact(DataTransferObjectInterface $contactDto ): void
    {
        $this->edit(self::TABLE, $contactDto);
    }

    /**
     * @throws ServiceException
     */
    public function getContact(): DataTransferObjectInterface
    {
        return $this->getAll(self::TABLE)[0];
    }
}