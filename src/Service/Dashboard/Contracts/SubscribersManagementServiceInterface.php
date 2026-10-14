<?php

declare(strict_types=1);

namespace App\Service\Dashboard\Contracts;

use App\DTO\Dashboard\Subscriber\SubscribersDto;

/**
 * Odczyt i usuwanie subskrybentów w dashboardzie, bez zmiany adresu lub aktywacji.
 */
interface SubscribersManagementServiceInterface extends SharedGetDataServiceInterface
{
    /**
     * Pobiera wszystkich subskrybentów.
     * @return SubscribersDto[]
     */
    public function getAllSubscribers(): array;

    /**
     * Usuwa subskrybenta.
     * @param int $id
     * @return void
     */
    public function deleteSubscriber(int $id): void;
}
