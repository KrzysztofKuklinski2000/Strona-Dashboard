<?php

namespace App\Service\Dashboard;

use App\Exception\ServiceException;
use App\Service\Dashboard\Traits\CanEdit;

class ContactService extends AbstractDashboardService implements ContactManagementServiceInterface
{
    use CanEdit;

    private const TABLE = 'contact';

    /**
     * @throws ServiceException
     */
    public function updateContact(array $data): void
    {
        $this->edit(self::TABLE, $data);
    }

    /**
     * @throws ServiceException
     */
    public function getContact(): array
    {
        return $this->getAll(self::TABLE)[0];
    }
}