<?php

declare(strict_types=1);

namespace App\Factories\ServiceFactories;

use App\Repository\Dashboard\TimetableRepository;
use PDO;
use App\Service\SiteService;
use App\Repository\SiteRepository;

readonly class SiteServiceFactory implements ServiceFactoryInterface
{
    public function __construct(private PDO $pdo)
    {
    }

    public function createService(): SiteService
    {
        $repository = new SiteRepository($this->pdo);
        $timetableRepository = new TimetableRepository($this->pdo);
        $homepageFeedRegistry = (new HomepageFeedRegistryFactory($this->pdo))->createService();

        return new SiteService(
            $repository,
            $timetableRepository,
            $homepageFeedRegistry,
        );
    }
}
