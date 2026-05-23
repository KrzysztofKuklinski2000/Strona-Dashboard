<?php

declare(strict_types=1);

namespace App\Service\Dashboard;

use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\DataTransferObjectInterface;

/**
 * Interfejs definiujący operacje wyłącznie dla modułu Aktualności.
 */
interface NewsManagementServiceInterface extends SharedGetDataServiceInterface
{
    /**
     * Pobiera wszystkie wpisy aktualności.
     * @return DataTransferObjectInterface[]
     */
    public function getAllNews(): array;

    /**
     * Aktualizuje istniejący wpis aktualności.
     * @param DataTransferObjectInterface $data Nowe dane z formularza.
     * @return void
     */
    public function updateNews(DataTransferObjectInterface $data): void;

    /**
     * Tworzy nowy wpis aktualności.
     * @param DataTransferObjectInterface $data Dane posta z formularza.
     * @return void
     */
    public function createNews(DataTransferObjectInterface $data): void;

    /**
     * Zmienia status publikacji wpisu.
     * @param DataTransferObjectInterface $data Dane posta z formularza.
     * @return void
     */
    public function publishedNews(DataTransferObjectInterface $data): void;

    /**
     * Usuwa wpis aktualności.
     * @param int $id ID posta do usunięcia.
     * @return void
     */
    public function deleteNews(int $id): void;

    /**
     * Zmienia pozycje wpisu.
     * @param ChangePositionDto $data Dane posta z formularza.
     * @return void
     */
    public function moveNews(ChangePositionDto $data): void;
}