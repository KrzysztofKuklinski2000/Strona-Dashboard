<?php

namespace App\Factories\ServiceFactories;

use App\Core\Config;
use App\Repository\Dashboard\TimetableRepository;
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
        return new SiteService($repository, $timetableRepository, $this->config->getItemsPerPage());
    }
}
