<?php

declare(strict_types=1);

namespace App\Service\Dashboard\Contracts;

use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\Dashboard\CreateMainPagePostDto;
use App\DTO\Dashboard\MainPageDto;
use App\DTO\Dashboard\PublishedDto;
use App\DTO\Dashboard\UpdateMainPagePostDto;

/**
 * Interfejs definiujący operacje wyłącznie dla modułu Strony Głównej.
 */
interface StartManagementServiceInterface extends SharedGetDataServiceInterface
{
    /**
     * Pobiera wszystkie wpisy Strony Głownej.
     * @return MainPageDto[]
     */
    public function getAllMain(): array;

    /**
     * Aktualizuje istniejący wpis Strony Głownej.
     * @param UpdateMainPagePostDto $data
     * @return void
     */
    public function updateMain(UpdateMainPagePostDto $data): void;

    /**
     * Tworzy nowy wpis Strony Głownej.
     * @param CreateMainPagePostDto $data
     * @return void
     */
    public function createMain(CreateMainPagePostDto $data): void;

    /**
     * Zmienia status publikacji Strony Głownej.
     * @param PublishedDto $data
     * @return void
     */
    public function publishedMain(PublishedDto $data): void;

    /**
     * Usuwa wpis na Stronie Głownej.
     * @param int $id
     * @return void
     */
    public function deleteMain(int $id): void;

    /**
     * Zmienia pozycje posta na Stronie Głownej.
     * @param ChangePositionDto $data
     * @return void
     */
    public function moveMain(ChangePositionDto $data): void;
}