<?php

namespace App\Service\Dashboard;

use App\DTO\Dashboard\ContactDto;
use App\Exception\ServiceException;
use App\Repository\Dashboard\ContactRepository;
use App\Service\Dashboard\Contracts\ContactManagementServiceInterface;
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
    public function updateContact(ContactDto $contactDto): void
    {
        $this->edit(self::TABLE, $contactDto);
    }

    /**
     * @throws ServiceException
     */
    public function getContact(): ContactDto
    {
        $contact = $this->getAll(self::TABLE)[0] ?? null;

        if (!$contact instanceof ContactDto) {
            throw new ServiceException('Nie udało się pobrać danych kontaktowych.');
        }

        return $contact;
    }
}