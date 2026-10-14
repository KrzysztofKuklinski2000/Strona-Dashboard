<?php

declare(strict_types=1);

namespace App\Service\Dashboard;

use App\DTO\DataTransferObjectInterface;
use App\Exception\NotFoundException;
use App\Exception\ServiceException;
use App\Repository\Dashboard\SubscriberRepository;
use App\Service\Dashboard\Contracts\SubscribersManagementServiceInterface;
use App\Service\Dashboard\Traits\CanDelete;

/**
 * Dashboard pozwala tylko przeglądać i usuwać subskrybentów.
 * Zapis i aktywacja adresu odbywają się wyłącznie przez publiczny formularz i link potwierdzający.
 */
class SubscribersService extends AbstractDashboardService implements SubscribersManagementServiceInterface
{
    use CanDelete;

    private const TABLE = 'subscribers';

    public function __construct(
        SubscriberRepository $repository,
    ) {
        parent::__construct($repository);
    }

    /**
     * Lista obejmuje rekordy aktywne i oczekujące, widoczne dla administratora.
     *
     * @throws ServiceException
     */
    public function getAllSubscribers(): array
    {
        return $this->getAll(self::TABLE, 'id');
    }

    /**
     * Pobiera pojedynczy rekord do podglądu lub potwierdzenia usunięcia.
     *
     * @throws ServiceException
     * @throws NotFoundException
     */
    public function getPost(int $id): DataTransferObjectInterface
    {
        return $this->getRow(self::TABLE, $id);
    }

    /**
     * Administracyjne usunięcie wskazanego rekordu, bez publicznego tokenu wypisania.
     */
    public function deleteSubscriber(int $id): void
    {
        $this->delete(self::TABLE, $id);
    }
}
