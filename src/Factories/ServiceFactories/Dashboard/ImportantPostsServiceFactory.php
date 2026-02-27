<?php

namespace App\Factories\ServiceFactories\Dashboard;

use App\Factories\ServiceFactories\ServiceFactoryInterface;
use App\Repository\DashboardRepository;
use App\Service\Dashboard\ImportantPostsService;
use PDO;

class ImportantPostsServiceFactory implements ServiceFactoryInterface
{
  public function __construct(private PDO $pdo) {}

  public function createService(): ImportantPostsService
  {
    $repository = new DashboardRepository($this->pdo);

    return new ImportantPostsService($repository);
  }
}
