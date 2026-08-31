<?php

declare(strict_types=1);

namespace App\Factories\ServiceFactories;

use App\Core\Config;
use App\Repository\Dashboard\TimetableRepository;
use App\Service\Homepage\Feed\GalleryFeedProvider;
use App\Service\Homepage\Feed\HomepageFeedRegistry;
use App\Service\Homepage\Feed\ImportantPostsFeedProvider;
use App\Service\Homepage\Feed\NewsFeedProvider;
use App\Service\Homepage\Feed\TimetableFeedProvider;
use PDO;
use App\Service\SiteService;
use App\Repository\SiteRepository;

readonly class SiteServiceFactory implements ServiceFactoryInterface
{
    public function __construct(private PDO $pdo, private Config $config)
    {
    }

    public function createService(): SiteService
    {
        $repository = new SiteRepository($this->pdo);
        $timetableRepository = new TimetableRepository($this->pdo);

        $homepageFeedRegistry = new HomepageFeedRegistry([
            new NewsFeedProvider($repository),
            new GalleryFeedProvider($repository),
            new ImportantPostsFeedProvider($repository),
            new TimetableFeedProvider($timetableRepository),
        ]);

        return new SiteService(
            $repository,
            $timetableRepository,
            $homepageFeedRegistry,
            $this->config->getItemsPerPage()
        );
    }
}
