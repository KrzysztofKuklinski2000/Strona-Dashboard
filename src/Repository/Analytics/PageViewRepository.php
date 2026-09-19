<?php
declare(strict_types=1);

namespace App\Repository\Analytics;

use App\Exception\RepositoryException;
use App\Repository\AbstractRepository;
use DateTimeImmutable;
use PDO;

class PageViewRepository extends AbstractRepository
{
    /**
     * @throws RepositoryException
     */
    public function record(string $path): void
    {
        try {
            $this->runQuery(
                'INSERT INTO page_views (path) VALUES (:path)',
                [':path' => $path]
            );
        } catch (RepositoryException $e) {
            throw new RepositoryException('Nie udało się zapisać odsłony', 500, $e);
        }
    }


    /**
     * @throws RepositoryException
     */
    public function countAll(): int
    {
        try {
            return (int)$this->runQuery('SELECT COUNT(*) FROM page_views')->fetchColumn();
        } catch (RepositoryException $e) {
            throw new RepositoryException('Nie udało się pobrać wszystkich odsłon', 500, $e);
        }
    }

    /**
     * @throws RepositoryException
     */
    public function countBetween(DateTimeImmutable $from, DateTimeImmutable $to): int
    {
        try {
            return (int)$this->runQuery(
                'SELECT COUNT(*) FROM page_views WHERE viewed_at >= :from AND viewed_at < :to',
                [
                    ':from' => $from->format('Y-m-d H:i:s'),
                    ':to' => $to->format('Y-m-d H:i:s')
                ]
            )->fetchColumn();
        } catch (RepositoryException $e) {
            throw new RepositoryException('Nie udało się pobrać odsłon z danego przedziału', 500, $e);
        }
    }

    /**
     * @throws RepositoryException
     */
    public function countGroupedByPath(): array
    {
        try {
            return $this->runQuery(
                'SELECT path, COUNT(*) AS countRows 
                    FROM page_views
                    GROUP BY path'
            )->fetchAll(PDO::FETCH_KEY_PAIR);
        } catch (RepositoryException $e) {
            throw new RepositoryException('Nie udało się pobrać pogrupowanych odsłon', 500, $e);
        }
    }

    /**
     * @throws RepositoryException
     */
    public function countGroupedByDay(DateTimeImmutable $from, DateTimeImmutable $to): array {
        try {
            return $this->runQuery(
                'SELECT DATE(viewed_at) AS viewedDay, COUNT(*) AS countRows 
                    FROM page_views 
                    WHERE viewed_at >= :from AND viewed_at < :to
                    GROUP BY DATE(viewed_at)',
                [
                    ':from' => $from->format('Y-m-d'),
                    ':to' => $to->format('Y-m-d')
                ]
            )->fetchAll(PDO::FETCH_KEY_PAIR);
        }catch (RepositoryException $e) {
            throw new RepositoryException(
                'Nie udało się pobrać odsłon pogrupowanych według dnia',
                500,
                $e
            );
        }
    }
}