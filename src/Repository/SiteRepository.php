<?php

declare(strict_types=1);

namespace App\Repository;

use App\DTO\Dashboard\Camp\CampDto;
use App\DTO\Dashboard\Contact\ContactDto;
use App\DTO\Dashboard\Fees\FeesDto;
use App\DTO\Dashboard\Gallery\GalleryDto;
use App\DTO\Dashboard\GalleryCategory\GalleryCategoryDto;
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
    public function getGallery(array $categorySlugs = [], ?int $limit = null): array
    {
        try {
            $sql = "SELECT gallery.* FROM gallery WHERE gallery.status = 1";
            $params = [];

            if ($categorySlugs !== []) {
                $placeholders = [];

                foreach ($categorySlugs as $index => $categorySlug) {
                    $placeholders[] = ":category_slug_{$index}";
                    $params[":category_slug_{$index}"] = $categorySlug;
                }

                $sql .= ' AND EXISTS 
                            (SELECT 1 FROM gallery_category 
                            INNER JOIN gallery_categories 
                                ON gallery_categories.id = gallery_category.category_id
                            WHERE gallery_category.gallery_id = gallery.id
                                AND gallery_categories.slug IN ('. implode(', ', $placeholders) .')
                                AND gallery_categories.status = 1
                          )
                       ';
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

    /**
     * @throws RepositoryException
     */
    public function getGalleryCategoriesWithImages(): array
    {
        try {
            $sql = '
                SELECT gallery_categories.*
                FROM gallery_categories
                WHERE gallery_categories.status = 1
                  AND EXISTS (
                      SELECT 1
                      FROM gallery_category
                      INNER JOIN gallery
                          ON gallery.id = gallery_category.gallery_id
                      WHERE gallery_category.category_id = gallery_categories.id
                        AND gallery.status = 1
                  )
                ORDER BY gallery_categories.position ASC
        ';

            $categories = $this->runQuery($sql)->fetchAll(PDO::FETCH_ASSOC);

            return array_map(
                fn(array $category) => GalleryCategoryDto::fromArray($category),
                $categories
            );
        } catch (RepositoryException $e) {
            throw new RepositoryException(
                'Nie udało się pobrać kategorii zawierających zdjęcia.',
                500,
                $e
            );
        }
    }
}
