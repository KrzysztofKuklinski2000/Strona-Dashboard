<?php
declare(strict_types= 1);
namespace App\Repository;

use App\DTO\Dashboard\CampDto;
use App\DTO\Dashboard\ContactDto;
use App\DTO\Dashboard\FeesDto;
use App\DTO\Dashboard\GalleryDto;
use App\DTO\Dashboard\ImportantPostsDto;
use App\DTO\Dashboard\MainPageDto;
use App\DTO\Dashboard\NewsDto;
use App\Exception\RepositoryException;
use PDO;

class SiteRepository extends AbstractRepository {

    private function fetchCollection(string $table): array
    {
        try {
            $sql = "SELECT * FROM $table WHERE status = 1 ORDER BY position ASC";
            return $this->runQuery($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (RepositoryException $e) {
            throw new RepositoryException("Nie udało się pobrać danych z tabeli $table", 500, $e);
        }
    }

    /**
     * @throws RepositoryException
     */
    private function fetchSingleRecord(string $table): array
    {
        try {
            $sql = "SELECT * FROM $table";
            $result = $this->runQuery($sql)->fetch(PDO::FETCH_ASSOC);

            if (!$result) {
                throw new RepositoryException("Brak danych w tabeli $table", 404);
            }

            return $result;
        } catch (RepositoryException $e) {
            throw new RepositoryException("Nie udało się pobrać danych z tabeli $table", 500, $e);
        }
    }

    /**
     * @return MainPageDto[]
     * @throws RepositoryException
     */
    public function getMainPagePosts(): array
    {
        return array_map(fn(array $row) => MainPageDto::fromArray($row), $this->fetchCollection('main_page_posts'));
    }

    /**
     * @throws RepositoryException
     */
    public function getImportantPosts(): array
    {
        return array_map(fn(array $row) => ImportantPostsDto::fromArray($row), $this->fetchCollection('important_posts'));
    }

    /**
     * @throws RepositoryException
     */
    public function getContact(): ContactDto
    {
        return ContactDto::fromArray($this->fetchSingleRecord('contact'));
    }

    /**
     * @throws RepositoryException
     */
    public function getCamp(): CampDto
    {
        return CampDto::fromArray($this->fetchSingleRecord('camp'));
    }

    /**
     * @throws RepositoryException
     */
    public function getFees(): FeesDto
    {
        return FeesDto::fromArray($this->fetchSingleRecord('fees'));
    }

    public function getNews(int $limit, int $offset): array {
        try {
            $sql = "SELECT * FROM news WHERE status = 1 ORDER BY position ASC LIMIT :limit OFFSET :offset";

            $result = $this->runQuery($sql, [
                ':limit' => [$limit, PDO::PARAM_INT],
                ':offset' => [$offset, PDO::PARAM_INT]
            ])->fetchAll(PDO::FETCH_ASSOC);

            return array_map(fn(array $row) => NewsDto::fromArray($row), $result);
        } catch(RepositoryException $e){
            throw new RepositoryException('Nie udało się pobrać aktualności', 500, $e);
        }
    }

    /**
     * @throws RepositoryException
     */
    public function getGallery(?string $category = null): array {
        try {
            $sql = "SELECT * FROM gallery WHERE status = 1";
            $params = [];

            if($category && in_array($category, ["training","camp"])) {
                $sql .= " AND category = :category";
                $params[':category'] = $category;
            }

            $sql .= " ORDER BY position ASC";

            $result = $this->runQuery($sql, $params)->fetchAll(PDO::FETCH_ASSOC);

            return array_map(fn(array $row) => GalleryDto::fromArray($row), $result);
        } catch(RepositoryException $e){
            throw new RepositoryException('Nie udało się pobrać galeri', 500, $e);
        }
    }

    /**
     * @throws RepositoryException
     */
    public function countData(string $table): int {
        try {
            $stmt = $this->runQuery("SELECT COUNT(*) FROM $table");
            return (int) $stmt->fetchColumn();
        }catch(RepositoryException $e){
            throw new RepositoryException("Nie udało się pobrać liczby rekordów", 500, $e);
        }
    }

    /**
     * @throws RepositoryException
     */
    public function countPublishedNews(): int
    {
        try {
            $stmt = $this->runQuery('SELECT COUNT(*) FROM news WHERE status = 1');
            return (int) $stmt->fetchColumn();
        } catch (RepositoryException $e) {
            throw new RepositoryException('Nie udało się pobrać liczby aktualności', 500, $e);
        }
    }
}