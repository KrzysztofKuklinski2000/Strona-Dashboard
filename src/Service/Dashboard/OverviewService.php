<?php
declare(strict_types=1);

namespace App\Service\Dashboard;

use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Repository\Analytics\PageViewRepository;
use DateTimeImmutable;

readonly class OverviewService
{
    public function __construct(private PageViewRepository $pageViewRepository)
    {
    }


    /**
     * @throws ServiceException
     */
    public function getOverviewData(): array {
        $today = new DateTimeImmutable('today');
        $tomorrow = $today->modify('+1 day');
        $last7DaysStart = $today->modify('-6 days');
        $last30DaysStart = $today->modify('-29 days');

        $yesterday = $today->modify('-1 day');
        $previous7DaysStart = $last7DaysStart->modify('-7 days');
        $previous30DaysStart = $last30DaysStart->modify('-30 days');


        try {
            $allViews = $this->pageViewRepository->countAll();
            $todayViews = $this->pageViewRepository->countBetween($today, $tomorrow);
            $last7DaysViews = $this->pageViewRepository->countBetween($last7DaysStart, $tomorrow);
            $last30DaysViews = $this->pageViewRepository->countBetween($last30DaysStart, $tomorrow);

            $yesterdayViews = $this->pageViewRepository->countBetween($yesterday, $today);
            $previous7DaysViews = $this->pageViewRepository->countBetween($previous7DaysStart, $last7DaysStart);
            $previous30DaysViews = $this->pageViewRepository->countBetween($previous30DaysStart, $last30DaysStart);

        }catch (RepositoryException $e){
            throw new ServiceException('Nie udało się pobrać statystyk', 500, $e);
        }

        return [
            'pageViews' => [
                'total' => [
                    'views' => $allViews,
                    'percentageChange' => null,
                ],
                'today' => [
                    'views' => $todayViews,
                    'percentageChange' => $this->calculatePercentageChange($todayViews, $yesterdayViews),
                ],
                'last7Days' => [
                    'views' => $last7DaysViews,
                    'percentageChange' => $this->calculatePercentageChange($last7DaysViews, $previous7DaysViews),
                ],
                'last30Days' => [
                    'views' => $last30DaysViews,
                    'percentageChange' => $this->calculatePercentageChange($last30DaysViews, $previous30DaysViews),
                ],
            ],
            'viewsByPath' => $this->getViewsGroupedByPath(),
            'viewsByDay' => $this->getViewsGroupedByDay($last30DaysStart, $tomorrow),
        ];
    }

    /**
     * @throws ServiceException
     */
    private function getViewsGroupedByPath(): array {
        try {
            $groupedViewsByPath = $this->pageViewRepository->countGroupedByPath();
            $normalizedViews = [];

            foreach ($groupedViewsByPath as $path => $count) {
                $path = preg_replace(
                    '#^/aktualnosci/\d+/?$#',
                    '/aktualnosci',
                    $path
                );

                $normalizedViews[$path] =
                    ($normalizedViews[$path] ?? 0) + (int) $count;
            }

            arsort($normalizedViews);

            return $normalizedViews;
        }catch (RepositoryException $e){
            throw new ServiceException('Nie udało się pobrać statystyk', 500, $e);
        }
    }

    /**
     * @throws ServiceException
     */
    private function getViewsGroupedByDay(DateTimeImmutable $from, DateTimeImmutable $to): array {
        try {
            $viewsFromDatabase = $this->pageViewRepository->countGroupedByDay($from, $to);

            $result = [];

            while($from < $to) {
                $date = $from->format('Y-m-d');

                $result[$date] = (int) ($viewsFromDatabase[$date] ?? 0);

                $from = $from->modify('+1 day');
            }

            return $result;
        }catch (RepositoryException $e) {
            throw new ServiceException(
                'Nie udało się pobrać statystyk dziennych',
                500,
                $e
            );
        }
    }

    private function calculatePercentageChange(int $current, int $previous): ?float {
        if ($previous === 0) {
            return $current === 0 ? 0.0 : null;
        }

        return round(
            (($current - $previous) / $previous) * 100,
            1
        );
    }
}