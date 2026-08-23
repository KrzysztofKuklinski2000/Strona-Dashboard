<?php

declare(strict_types=1);

namespace App\Service\Dashboard\Contracts;

use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\Dashboard\CreateHomepagePostDto;
use App\DTO\Dashboard\HomepagePostDto;
use App\DTO\Dashboard\PublishedDto;
use App\DTO\Dashboard\UpdateHomepagePostDto;

/**
 * Interfejs definiujący operacje wyłącznie dla modułu Strony Głównej.
 */
interface HomepageManagementServiceInterface extends SharedGetDataServiceInterface
{
    /**
     * Pobiera wszystkie wpisy Strony Głownej.
     * @return HomepagePostDto[]
     */
    public function getAllHomepagePosts(): array;

    /**
     * Aktualizuje istniejący wpis Strony Głownej.
     * @param UpdateHomepagePostDto $data
     * @return void
     */
    public function updateHomepagePost(UpdateHomepagePostDto $data): void;

    /**
     * Tworzy nowy wpis Strony Głownej.
     * @param CreateHomepagePostDto $data
     * @return void
     */
    public function createHomepagePost(CreateHomepagePostDto $data): void;

    /**
     * Zmienia status publikacji Strony Głownej.
     * @param PublishedDto $data
     * @return void
     */
    public function publishedHomepagePost(PublishedDto $data): void;

    /**
     * Usuwa wpis na Stronie Głownej.
     * @param int $id
     * @return void
     */
    public function deleteHomepagePost(int $id): void;

    /**
     * Zmienia pozycje posta na Stronie Głownej.
     * @param ChangePositionDto $data
     * @return void
     */
    public function moveHomepagePost(ChangePositionDto $data): void;
}
