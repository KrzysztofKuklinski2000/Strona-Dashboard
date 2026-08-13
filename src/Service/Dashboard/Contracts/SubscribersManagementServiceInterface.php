<?php

declare(strict_types=1);

namespace App\Service\Dashboard\Contracts;

use App\DTO\Dashboard\CreateSubscriberDto;
use App\DTO\Dashboard\SubscribersDto;
use App\DTO\Dashboard\UpdateSubscriberDto;

/**
 * Interfejs definiujący operacje wyłącznie dla modułu Subscribers.
 */
interface SubscribersManagementServiceInterface extends SharedGetDataServiceInterface
{
    /**
     * Pobiera wszystkich subskrybentów.
     * @return SubscribersDto[]
     */
    public function getAllSubscribers(): array;

    /**
     * Tworzy nowych subskrybenta
     * @param CreateSubscriberDto $data
     * @return string
     */
    public function createSubscriber(CreateSubscriberDto $data): string;

    /**
     * Aktualizuje dane subskrybenta.
     * @param UpdateSubscriberDto $data
     * @return void
     */
    public function updateSubscriber(UpdateSubscriberDto $data): void;

    /**
     * Usuwa subskrybenta.
     * @param int $id
     * @return void
     */
    public function deleteSubscriber(int $id): void;
}
