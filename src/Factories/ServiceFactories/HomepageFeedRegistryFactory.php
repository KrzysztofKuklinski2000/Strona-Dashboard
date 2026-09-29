<?php

declare(strict_types=1);

namespace App\Factories\ServiceFactories;

use App\Repository\Dashboard\TimetableRepository;
use App\Repository\PublicNewsRepository;
use App\Repository\SiteRepository;
use App\Service\Homepage\Feed\GalleryFeedProvider;
use App\Service\Homepage\Feed\HomepageFeedRegistry;
use App\Service\Homepage\Feed\ImportantPostsFeedProvider;
use App\Service\Homepage\Feed\NewsFeedProvider;
use App\Service\Homepage\Feed\TimetableFeedProvider;
use PDO;

final readonly class HomepageFeedRegistryFactory implements ServiceFactoryInterface
{
    public function __construct(private PDO $pdo)
    {
    }

    public function createService(): HomepageFeedRegistry
    {
        $siteRepository = new SiteRepository($this->pdo);

        return new HomepageFeedRegistry([
            new NewsFeedProvider(new PublicNewsRepository($this->pdo)),
            new GalleryFeedProvider($siteRepository),
            new ImportantPostsFeedProvider($siteRepository),
            new TimetableFeedProvider(new TimetableRepository($this->pdo)),
        ]);
    }
}
