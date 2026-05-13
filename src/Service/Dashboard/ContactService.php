<?php

namespace App\Service\Dashboard;

use App\DTO\Dashboard\ContactDto;
use App\Exception\ServiceException;
use App\Service\Dashboard\Traits\CanEdit;

class ContactService extends AbstractDashboardService implements ContactManagementServiceInterface
{
    use CanEdit;

    private const TABLE = 'contact';

    /**
     * @throws ServiceException
     */
    public function updateContact(ContactDto $contactDto ): void
    {
        $this->edit(self::TABLE, $contactDto->toArray());
    }

    /**
     * @throws ServiceException
     */
    public function getContact(): ContactDto
    {
        return ContactDto::fromArray($this->getAll(self::TABLE)[0]);
    }
}