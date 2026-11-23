<?php

declare(strict_types=1);

namespace App\Service\Dashboard;

use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Repository\Dashboard\OverviewRepository;

readonly class OverviewService
{
    public function __construct(private OverviewRepository $overviewRepository)
    {
    }

    /**
     * @throws ServiceException
     */
    public function getOverviewData(): array
    {
        try {
            $contentSummary = $this->overviewRepository->getContentSummary();
        } catch (RepositoryException $e) {
            throw new ServiceException('Nie udało się pobrać statystyk', 500, $e);
        }

        return [
            'contentSummary' => $this->groupContentSummary($contentSummary),
        ];
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
}
