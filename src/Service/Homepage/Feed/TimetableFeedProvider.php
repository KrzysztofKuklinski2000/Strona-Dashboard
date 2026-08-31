<?php
declare(strict_types=1);

namespace App\Service\Homepage\Feed;

use App\Content\HomepageFeedModules;
use App\Exception\RepositoryException;
use App\Repository\Dashboard\TimetableRepository;

final readonly class TimetableFeedProvider implements HomepageFeedProviderInterface
{
    public function __construct(
        private TimetableRepository $timetableRepository
    )
    {
    }

    public function module(): string
    {
        return HomepageFeedModules::TIMETABLE;
    }

    /**
     * @throws RepositoryException
     */
    public function getItems(int $limit): array
    {
        return $this->timetableRepository->timetablePageData(
            limit: $limit,
            publishedOnly: true);
    }
}