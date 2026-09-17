<?php
declare(strict_types=1);

namespace App\Service\Dashboard;

use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Repository\Analytics\PageViewRepository;
use DateTimeImmutable;

class OverviewService
{
    public function __construct(private readonly PageViewRepository $pageViewRepository)
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


        try {
            $allViews = $this->pageViewRepository->countAll();
            $todayViews = $this->pageViewRepository->countBetween($today, $tomorrow);
            $last7DaysViews = $this->pageViewRepository->countBetween($last7DaysStart, $tomorrow);
            $last30DaysViews = $this->pageViewRepository->countBetween($last30DaysStart, $tomorrow);
        }catch (RepositoryException $e){
            throw new ServiceException('Nie udało się pobrać statystyk', 500, $e);
        }


        return [
            'pageViews' => [
                'total' => $allViews,
                'today' => $todayViews,
                'last7Days' => $last7DaysViews,
                'last30Days' => $last30DaysViews,
            ]
        ];
    }
}