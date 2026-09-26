<?php

declare(strict_types=1);

namespace App\Repository;

use App\DTO\Dashboard\Camp\CampDto;
use App\DTO\Dashboard\Contact\ContactDto;
use App\DTO\Dashboard\Fees\FeesDto;
use App\DTO\Dashboard\Gallery\GalleryDto;
use App\DTO\Dashboard\Homepage\HomepagePostDto;
use App\DTO\Dashboard\ImportantPosts\ImportantPostsDto;
use App\Exception\NotFoundException;
use App\Exception\RepositoryException;
use PDO;

class SiteRepository extends AbstractRepository
{
    /**
     * @throws RepositoryException
     */
    private function fetchCollection(string $table, ?int $limit = null): array
    {
        try {
            $sql = "SELECT * FROM $table WHERE status = 1 ORDER BY position ASC ";
            $params = [];

            if($limit !== null){
                $sql .= " LIMIT :limit";
                $params[':limit'] = [$limit, PDO::PARAM_INT];
            }

            return $this->runQuery(
                $sql,
                $params
            )->fetchAll(PDO::FETCH_ASSOC);
        } catch (RepositoryException $e) {
            throw new RepositoryException("Nie udało się pobrać danych z tabeli $table", 500, $e);
        }
    }

    /**
     * @throws RepositoryException
     * @throws NotFoundException
     */
    private function fetchSingleRecord(string $table): array
    {
        try {
            $sql = "SELECT * FROM $table WHERE id = :id";
            $result = $this->runQuery($sql, [':id' => 1])->fetch(PDO::FETCH_ASSOC);
        } catch (RepositoryException $e) {
            throw new RepositoryException("Nie udało się pobrać danych z tabeli $table", 500, $e);
        }

        if (!$result) {
            throw new NotFoundException("Brak danych w tabeli $table", 404);
        }

        return $result;
    }

    /**
     * @return HomepagePostDto[]
     * @throws RepositoryException
     */
    public function getHomepagePosts(): array
    {
        return array_map(fn (array $row) => HomepagePostDto::fromArray($row), $this->fetchCollection('homepage_posts'));
    }

    /**
     * @throws RepositoryException
     */
    public function getImportantPosts(?int $limit = null): array
    {
        return array_map(fn (array $row) => ImportantPostsDto::fromArray($row), $this->fetchCollection('important_posts', $limit));
    }

    /**
     * @throws RepositoryException
     * @throws NotFoundException
     */
    public function getContact(): ContactDto
    {
        return ContactDto::fromArray($this->fetchSingleRecord('contact'));
    }

    /**
     * @throws RepositoryException
     * @throws NotFoundException
     */
    public function getCamp(): CampDto
    {
        return CampDto::fromArray($this->fetchSingleRecord('camp'));
    }

    /**
     * @throws RepositoryException
     * @throws NotFoundException
     */
    public function getFees(): FeesDto
    {
        return FeesDto::fromArray($this->fetchSingleRecord('fees'));
    }

    /**
     * @throws RepositoryException
     */
    public function getGallery(?string $category = null, ?int $limit = null): array
    {
        try {
            $sql = "SELECT * FROM gallery WHERE status = 1";
            $params = [];

            if ($category && in_array($category, ["training","camp"])) {
                $sql .= " AND category = :category";
                $params[':category'] = $category;
            }

            $sql .= " ORDER BY position ASC";

            if($limit !== null){
                $sql .= " LIMIT :limit";
                $params[':limit'] = [$limit, PDO::PARAM_INT];
            }

            $result = $this->runQuery($sql, $params)->fetchAll(PDO::FETCH_ASSOC);

            return array_map(fn (array $row) => GalleryDto::fromArray($row), $result);
        } catch (RepositoryException $e) {
            throw new RepositoryException('Nie udało się pobrać galeri', 500, $e);
        }
    }
}
