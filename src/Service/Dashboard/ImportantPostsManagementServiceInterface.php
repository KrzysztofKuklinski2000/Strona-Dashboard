<?php

declare(strict_types=1);

namespace App\Service\Dashboard;

use App\DTO\DataTransferObjectInterface;

/**
 * Interfejs definiujący operacje wyłącznie dla modułu Aktualności.
 */
interface ImportantPostsManagementServiceInterface extends SharedGetDataServiceInterface
{
    /**
     * Pobiera wszystkie ważnych postów.
     * @return array
     */
    public function getAllImportantPosts(): array;

    /**
     * Aktualizuje istniejący ważnych wpis.
     * @param DataTransferObjectInterface $data Nowe dane z formularza.
     * @return void
     */
    public function updateImportantPost(DataTransferObjectInterface $data): void;

    /**
     * Tworzy nowy ważnych wpis.
     * @param DataTransferObjectInterface $data Dane posta z formularza.
     * @return void
     */
    public function createImportantPost(DataTransferObjectInterface $data): void;

    /**
     * Zmienia status publikacji wpisu.
     * @param DataTransferObjectInterface $data Dane posta z formularza.
     * @return void
     */
    public function publishedImportantPost(DataTransferObjectInterface $data): void;

    /**
     * Usuwa ważnych wpis.
     * @param int $id ID posta do usunięcia.
     * @return void
     */
    public function deleteImportantPost(int $id): void;

    /**
     * Zmienia pozycje wpisu.
     * @param DataTransferObjectInterface $data Dane posta z formularza.
     * @return void
     */
    public function moveImportantPost(DataTransferObjectInterface $data): void;
}
