<?php

declare(strict_types=1);

namespace App\Service\Dashboard\Contracts;

use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\Dashboard\CreateImportantPostDto;
use App\DTO\Dashboard\ImportantPostsDto;
use App\DTO\Dashboard\PublishedDto;
use App\DTO\Dashboard\UpdateImportantPostDto;

/**
 * Interfejs definiujący operacje wyłącznie dla modułu Ważnych Informacji.
 */
interface ImportantPostsManagementServiceInterface extends SharedGetDataServiceInterface
{
    /**
     * Pobiera wszystkie ważnych postów.
     * @return ImportantPostsDto[]
     */
    public function getAllImportantPosts(): array;

    /**
     * Aktualizuje istniejący ważnych wpis.
     * @param UpdateImportantPostDto $data
     * @return void
     */
    public function updateImportantPost(UpdateImportantPostDto $data): void;

    /**
     * Tworzy nowy ważnych wpis.
     * @param CreateImportantPostDto $data
     * @return void
     */
    public function createImportantPost(CreateImportantPostDto $data): void;

    /**
     * Zmienia status publikacji wpisu.
     * @param PublishedDto $data
     * @return void
     */
    public function publishedImportantPost(PublishedDto $data): void;

    /**
     * Usuwa ważnych wpis.
     * @param int $id
     * @return void
     */
    public function deleteImportantPost(int $id): void;

    /**
     * Zmienia pozycje wpisu.
     * @param ChangePositionDto $data
     * @return void
     */
    public function moveImportantPost(ChangePositionDto $data): void;
}
