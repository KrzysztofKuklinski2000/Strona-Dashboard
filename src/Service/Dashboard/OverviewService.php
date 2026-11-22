<?php

declare(strict_types=1);

namespace App\Service\Dashboard;

use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Repository\Analytics\UniqueVisitorRepository;
use App\Repository\Dashboard\OverviewRepository;
use DateTimeImmutable;
use DateTimeZone;
use Exception;

readonly class OverviewService
{
    public function __construct(
        private UniqueVisitorRepository $uniqueVisitorRepository,
        private OverviewRepository      $overviewRepository,
    ) {
    }

    /**
     * @throws ServiceException
     * @throws Exception
     */
    public function getOverviewData(): array
    {
        $today = new DateTimeImmutable('today', new DateTimeZone('Europe/Warsaw'));
        $tomorrow = $today->modify('+1 day');
        $last7DaysStart = $today->modify('-6 days');
        $last30DaysStart = $today->modify('-29 days');

        $yesterday = $today->modify('-1 day');
        $previous7DaysStart = $last7DaysStart->modify('-7 days');
        $previous30DaysStart = $last30DaysStart->modify('-30 days');

        try {
            $allVisitors = $this->uniqueVisitorRepository->countAll();
            $todayVisitors = $this->uniqueVisitorRepository->countBetween($today, $tomorrow);
            $last7DaysVisitors = $this->uniqueVisitorRepository->countBetween($last7DaysStart, $tomorrow);
            $last30DaysVisitors = $this->uniqueVisitorRepository->countBetween($last30DaysStart, $tomorrow);

            $yesterdayVisitors = $this->uniqueVisitorRepository->countBetween($yesterday, $today);
            $previous7DaysVisitors = $this->uniqueVisitorRepository->countBetween($previous7DaysStart, $last7DaysStart);
            $previous30DaysVisitors = $this->uniqueVisitorRepository->countBetween($previous30DaysStart, $last30DaysStart);

            $contentSummary = $this->overviewRepository->getContentSummary();

        } catch (RepositoryException $e) {
            throw new ServiceException('Nie udało się pobrać statystyk', 500, $e);
        }

        return [
            'uniqueVisitors' => [
                'total' => [
                    'count' => $allVisitors,
                    'percentageChange' => null,
                ],
                'today' => [
                    'count' => $todayVisitors,
                    'percentageChange' => $this->calculatePercentageChange($todayVisitors, $yesterdayVisitors),
                ],
                'last7Days' => [
                    'count' => $last7DaysVisitors,
                    'percentageChange' => $this->calculatePercentageChange($last7DaysVisitors, $previous7DaysVisitors),
                ],
                'last30Days' => [
                    'count' => $last30DaysVisitors,
                    'percentageChange' => $this->calculatePercentageChange($last30DaysVisitors, $previous30DaysVisitors),
                ],
            ],
            'visitorsByPath' => $this->getVisitorsGroupedByPath(),
            'visitorsByDay' => $this->getVisitorsGroupedByDay($last30DaysStart, $today, $todayVisitors),
            'contentSummary' => $this->groupContentSummary($contentSummary),
        ];
    }

    /**
     * @throws ServiceException
     */
    private function getVisitorsGroupedByPath(): array
    {
        try {
            $groupedVisitorsByPath = $this->uniqueVisitorRepository->countGroupedByPath();
            $visitorsByPath = [];

            foreach ($groupedVisitorsByPath as $path => $count) {
                $visitorsByPath[$path] = (int) $count;
            }

            arsort($visitorsByPath);

            return $visitorsByPath;
        } catch (RepositoryException $e) {
            throw new ServiceException('Nie udało się pobrać statystyk', 500, $e);
        }
    }
    private function calculatePercentageChange(int $current, int $previous): ?float
    {
        if ($previous === 0) {
            return $current === 0 ? 0.0 : null;
        }

        return round(
            (($current - $previous) / $previous) * 100,
            1
        );
    }

    private function groupContentSummary(array $contentSummary): array
    {
        return [
            'news' => [
                'total' => $contentSummary['totalNews'],
                'published' => $contentSummary['publishedNews'],
                'percentage' => $this->calculateSharePercentage(
                    $contentSummary['publishedNews'],
                    $contentSummary['totalNews']
                ),
            ],
            'homepagePosts' => [
                'total' => $contentSummary['totalHomepagePosts'],
                'published' => $contentSummary['publishedHomepagePosts'],
                'percentage' => $this->calculateSharePercentage(
                    $contentSummary['publishedHomepagePosts'],
                    $contentSummary['totalHomepagePosts']
                ),
            ],
            'gallery' => [
                'total' => $contentSummary['totalGallery'],
                'published' => $contentSummary['publishedGallery'],
                'percentage' => $this->calculateSharePercentage(
                    $contentSummary['publishedGallery'],
                    $contentSummary['totalGallery']
                ),
            ],
            'importantPosts' => [
                'total' => $contentSummary['totalImportantPosts'],
                'published' => $contentSummary['publishedImportantPosts'],
                'percentage' => $this->calculateSharePercentage(
                    $contentSummary['publishedImportantPosts'],
                    $contentSummary['totalImportantPosts']
                ),
            ],
            'timetable' => [
                'total' => $contentSummary['totalTimetable'],
                'published' => $contentSummary['publishedTimetable'],
                'percentage' => $this->calculateSharePercentage(
                    $contentSummary['publishedTimetable'],
                    $contentSummary['totalTimetable']
                ),
            ],
            'subscribers' => [
                'total' => $contentSummary['totalSubscribers'],
                'active' => $contentSummary['activeSubscribers'],
                'percentage' => $this->calculateSharePercentage(
                    $contentSummary['activeSubscribers'],
                    $contentSummary['totalSubscribers']
                ),
            ]
        ];
    }

    private function calculateSharePercentage(int $part, int $total): float
    {
        if ($total === 0) {
            return 0.0;
        }

        return round(($part / $total) * 100, 1);
    }

    /**
     * @throws ServiceException
     */
    private function getVisitorsGroupedByDay(
        DateTimeImmutable $from,
        DateTimeImmutable $today,
        int $todayVisitors,
    ): array {

        try {
            $archived = $this->uniqueVisitorRepository->getArchivedDailyTotals($from, $today);
        } catch (RepositoryException $e) {
            throw new ServiceException('Nie udało się pobrać statystyk dziennych', 500, $e);
        }

        $result = [];

        for ($day = $from; $day < $today; $day = $day->modify('+1 day')) {
            $date = $day->format('Y-m-d');
            $result[$date] = isset($archived[$date]) ? (int) $archived[$date] : null;
        }

        $result[$today->format('Y-m-d')] = $todayVisitors;

        return $result;
    }
}
