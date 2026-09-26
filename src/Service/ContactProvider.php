<?php
declare(strict_types=1);

namespace App\Service;

use App\DTO\Dashboard\Contact\ContactDto;
use App\Exception\NotFoundException;
use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Repository\SiteRepository;
use App\Service\Contracts\ContactProviderInterface;

final readonly class ContactProvider implements ContactProviderInterface
{
    public function __construct(
        private SiteRepository $repository,
    ) {
    }

    /**
     * @throws ServiceException
     * @throws NotFoundException
     */
    public function getContact(): ContactDto
    {
        try {
            return $this->repository->getContact();
        } catch (RepositoryException $e) {
            throw new ServiceException("Nie udało się pobrać danych kontaktowych", 500, $e);
        }
    }
}