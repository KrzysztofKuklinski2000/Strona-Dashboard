<?php

declare(strict_types=1);

namespace App\Service\Dashboard;

use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\DataTransferObjectInterface;

/**
 * Interfejs definiujący operacje wyłącznie dla modułu Aktualności.
 */
interface StartManagementServiceInterface extends SharedGetDataServiceInterface
{
    /**
     * Pobiera wszystkie wpisy Strony Głownej.
     * @return DataTransferObjectInterface[]
     */
    public function getAllMain(): array;

    /**
     * Aktualizuje istniejący wpis Strony Głownej.
     * @param DataTransferObjectInterface $data Nowe dane z formularza.
     * @return void
     */
    public function updateMain(DataTransferObjectInterface $data): void;

    /**
     * Tworzy nowy wpis Strony Głownej.
     * @param DataTransferObjectInterface $data Dane posta z formularza.
     * @return void
     */
    public function createMain(DataTransferObjectInterface $data): void;

    /**
     * Zmienia status publikacji Strony Głownej.
     * @param DataTransferObjectInterface $data Dane posta z formularza.
     * @return void
     */
    public function publishedMain(DataTransferObjectInterface $data): void;

    /**
     * Usuwa wpis na Stronie Głownej.
     * @param int $id ID posta do usunięcia.
     * @return void
     */
    public function deleteMain(int $id): void;

    /**
     * Zmienia pozycje posta na Stronie Głownej.
     * @param ChangePositionDto $data Dane posta z formularza.
     * @return void
     */
    public function moveMain(ChangePositionDto $data): void;
}