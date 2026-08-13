<?php

declare(strict_types=1);

namespace App\Service\Dashboard\Contracts;

use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\Dashboard\CreateNewsDto;
use App\DTO\Dashboard\NewsDto;
use App\DTO\Dashboard\PublishedDto;
use App\DTO\Dashboard\UpdateNewsDto;

/**
 * Interfejs definiujący operacje wyłącznie dla modułu Aktualności.
 */
interface NewsManagementServiceInterface extends SharedGetDataServiceInterface
{
    /**
     * Pobiera wszystkie wpisy aktualności.
     * @return NewsDto[]
     */
    public function getAllNews(): array;

    /**
     * Aktualizuje istniejący wpis aktualności.
     * @param UpdateNewsDto $data
     * @return void
     */
    public function updateNews(UpdateNewsDto $data): void;

    /**
     * Tworzy nowy wpis aktualności.
     * @param CreateNewsDto $data
     * @return void
     */
    public function createNews(CreateNewsDto $data): void;

    /**
     * Zmienia status publikacji wpisu.
     * @param PublishedDto $data
     * @return void
     */
    public function publishedNews(PublishedDto $data): void;

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