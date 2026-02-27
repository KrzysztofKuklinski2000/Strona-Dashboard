<?php

namespace App\Factories\ServiceFactories\Dashboard;

use App\Factories\ServiceFactories\ServiceFactoryInterface;
use App\Repository\DashboardRepository;
use App\Service\Dashboard\NewsService;
use PDO;

class NewsServiceFactory implements ServiceFactoryInterface
{
  public function __construct(private PDO $pdo) {}

  public function createService(): NewsService
  {
    $repository = new DashboardRepository($this->pdo);

    return new NewsService($repository);
  }
}
