<?php
declare(strict_types=1);

namespace App\Repository;

use App\DTO\Dashboard\News\NewsDto;
use App\Exception\RepositoryException;
use PDO;

class PublicNewsRepository extends AbstractRepository
{
    /**
     * @throws RepositoryException
     */
    public function getNews(int $limit, int $offset): array
    {
        try {
            $sql = "SELECT * FROM news WHERE status = 1 ORDER BY position ASC LIMIT :limit OFFSET :offset";

            $result = $this->runQuery($sql, [
                ':limit' => [$limit, PDO::PARAM_INT],
                ':offset' => [$offset, PDO::PARAM_INT]
            ])->fetchAll(PDO::FETCH_ASSOC);

            return array_map(fn (array $row) => NewsDto::fromArray($row), $result);
        } catch (RepositoryException $e) {
            throw new RepositoryException('Nie udało się pobrać aktualności', 500, $e);
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