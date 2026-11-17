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
    public function recordUniqueVisit(
        string            $path,
        DateTimeImmutable $visitDate,
        string            $visitorHash
    ): void
    {
        try {
            $this->runQuery(
                'INSERT INTO visitor_page_days (path, visit_date, visitor_hash)
                        VALUES (:path, :visit_date, :visitor_hash)
                        ON DUPLICATE KEY UPDATE visitor_hash = visitor_hash',
                [
                    ':path' => $path,
                    'visit_date' => $visitDate->format('Y-m-d'),
                    'visitor_hash' => $visitorHash
                ],
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
            return (int)$this->runQuery('SELECT COUNT(DISTINCT visitor_hash) FROM visitor_page_days')->fetchColumn();
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
                'SELECT COUNT(DISTINCT visitor_hash) FROM visitor_page_days WHERE visit_date >= :from AND visit_date < :to',
                [
                    ':from' => $from->format('Y-m-d'),
                    ':to' => $to->format('Y-m-d')
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
                'SELECT path, COUNT(DISTINCT visitor_hash) AS countRows 
                    FROM visitor_page_days
                    GROUP BY path'
            )->fetchAll(PDO::FETCH_KEY_PAIR);
        } catch (RepositoryException $e) {
            throw new RepositoryException('Nie udało się pobrać pogrupowanych odsłon', 500, $e);
        }
    }

    /**
     * @throws RepositoryException
     */
    public function countGroupedByDay(DateTimeImmutable $from, DateTimeImmutable $to): array
    {
        try {
            return $this->runQuery(
                'SELECT visit_date, COUNT(DISTINCT visitor_hash) AS countRows 
                    FROM visitor_page_days 
                    WHERE visit_date >= :from AND visit_date < :to
                    GROUP BY visit_date',
                [
                    ':from' => $from->format('Y-m-d'),
                    ':to' => $to->format('Y-m-d')
                ]
            )->fetchAll(PDO::FETCH_KEY_PAIR);
        } catch (RepositoryException $e) {
            throw new RepositoryException(
                'Nie udało się pobrać odsłon pogrupowanych według dnia',
                500,
                $e
            );
        }
    }
}