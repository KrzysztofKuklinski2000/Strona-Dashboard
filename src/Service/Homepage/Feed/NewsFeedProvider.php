<?php
declare(strict_types=1);

namespace App\Service\Homepage\Feed;

use App\Content\HomepageFeedModules;
use App\Exception\RepositoryException;
use App\Repository\SiteRepository;

final readonly class NewsFeedProvider implements HomepageFeedProviderInterface
{

    public function __construct(private SiteRepository $siteRepository)
    {
    }

    public function module(): string
    {
        return HomepageFeedModules::NEWS;
    }

    /**
     * @throws RepositoryException
     */
    public function getItems(int $limit): array {
        return $this->siteRepository->getNews($limit, 0);
    }

}