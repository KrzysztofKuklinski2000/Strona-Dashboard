<?php

declare(strict_types=1);

namespace App\Service\Dashboard;

use App\DTO\DataTransferObjectInterface;

/**
 * Interfejs definiujący operacje wyłącznie dla modułu Subscribers.
 */
interface SubscribersManagementServiceInterface extends SharedGetDataServiceInterface
{
    /**
     * Pobiera wszystkich subskrybentów.
     * @return array
     */
    public function getAllSubscribers(): array;

    /**
     * Tworzy nowych subskrybenta .
     * @param DataTransferObjectInterface $data Dane posta z formularza.
     * @return string
     */
    public function createSubscriber(DataTransferObjectInterface $data): string;

    /**
     * Aktualizuje dane subskrybenta.
     * @param DataTransferObjectInterface $data Nowe dane z formularza.
     * @return void
     */
    public function updateSubscriber(DataTransferObjectInterface $data): void;

    /**
     * Usuwa subskrybenta.
     * @param int $id ID subskrybenta do usunięcia.
     * @return void
     */
    public function deleteSubscriber(int $id): void;
}
