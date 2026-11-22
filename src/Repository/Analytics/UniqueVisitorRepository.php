<?php

declare(strict_types=1);

namespace App\Repository\Analytics;

use App\Exception\RepositoryException;
use App\Repository\AbstractRepository;
use DateTimeImmutable;
use PDO;

class UniqueVisitorRepository extends AbstractRepository
{
    /**
     * @throws RepositoryException
     */
    public function recordUniqueVisit(
        string            $path,
        DateTimeImmutable $visitDate,
        string            $visitorHash
    ): void {
        try {
            $this->runQuery(
                'INSERT INTO visitor_page_days (path, visit_date, visitor_hash)
                    VALUES (:path, :visit_date, :visitor_hash)
                    ON DUPLICATE KEY UPDATE visitor_hash = visitor_hash',
                [
                    ':path' => $path,
                    ':visit_date' => $visitDate->format('Y-m-d'),
                    ':visitor_hash' => $visitorHash
                ],
            );
        } catch (RepositoryException $e) {
            throw new RepositoryException('Nie udało się zapisać unikalnej wizyty', 500, $e);
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
            throw new RepositoryException('Nie udało się pobrać liczby unikalnych odwiedzających', 500, $e);
        }
    }

    /**
     * @throws RepositoryException
     */
    public function countBetween(DateTimeImmutable $from, DateTimeImmutable $to): int
    {
        try {
            return (int)$this->runQuery(
                'SELECT COUNT(DISTINCT visitor_hash) 
                    FROM visitor_page_days 
                    WHERE visit_date >= :from AND visit_date < :to',
                [
                    ':from' => $from->format('Y-m-d'),
                    ':to' => $to->format('Y-m-d')
                ]
            )->fetchColumn();
        } catch (RepositoryException $e) {
            throw new RepositoryException('Nie udało się pobrać liczby unikalnych odwiedzających z danego przedziału', 500, $e);
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
            throw new RepositoryException('Nie udało się pobrać liczby unikalnych odwiedzających według strony', 500, $e);
        }
    }

    /**
     * @throws RepositoryException
     */
    public function getArchivedDailyTotals(DateTimeImmutable $from, DateTimeImmutable $to): array
    {
        try {
            return $this->runQuery(
                'SELECT visit_date, unique_visitors
                    FROM visitor_daily_totals
                    WHERE visit_date >= :from AND visit_date < :to',
                [
                    ':from' => $from->format('Y-m-d'),
                    ':to' => $to->format('Y-m-d')
                ]
            )->fetchAll(PDO::FETCH_KEY_PAIR);
        } catch (RepositoryException $e) {
            throw new RepositoryException(
                'Nie udało się pobrać liczby unikalnych odwiedzających według dnia',
                500,
                $e
            );
        }
    }

    /**
     * @throws RepositoryException
     */
    public function deleteHistory(string $visitorId): bool {
        try {
            $sql = "DELETE FROM visitor_page_days WHERE visitor_hash = :visitorId";

            $stmt = $this->runQuery($sql, [':visitorId' => $visitorId]);
        }catch (RepositoryException $e) {
            throw new RepositoryException('Nie udało się usunąć historii', 500, $e);
        }

        return true;
    }

    /**
     * @throws RepositoryException
     */
    public function saveDailyTotal(DateTimeImmutable $day, int $count): void {
        $this->runQuery('INSERT INTO visitor_daily_totals (visit_date, unique_visitors)
        VALUES (:visit_date, :unique_visitors)
        ON DUPLICATE KEY UPDATE unique_visitors = visitor_daily_totals.unique_visitors',
            [
                ':visit_date' => $day->format('Y-m-d'),
                ':unique_visitors' => [$count, PDO::PARAM_INT]
            ],
        );
    }

    public function saveDailyPageTotals(DateTimeImmutable $day): void {
        $this->runQuery(
            'INSERT INTO visitor_daily_page_totals (visit_date, path, unique_visitors)
                SELECT visits.visit_date, visits.path, COUNT(*)
                FROM visitor_page_days AS visits
                WHERE visits.visit_date = :visit_date
                GROUP BY visits.visit_date, visits.path
                ON DUPLICATE KEY UPDATE unique_visitors =  visitor_daily_page_totals.unique_visitors',
            [':visit_date' => $day->format('Y-m-d')],
        );
    }
}
