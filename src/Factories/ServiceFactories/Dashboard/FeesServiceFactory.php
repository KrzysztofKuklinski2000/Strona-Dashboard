<?php

namespace App\Factories\ServiceFactories\Dashboard;

use App\Factories\ServiceFactories\ServiceFactoryInterface;
use App\Repository\DashboardRepository;
use App\Service\Dashboard\FeesService;
use PDO;

class FeesServiceFactory implements ServiceFactoryInterface
{
  public function __construct(private PDO $pdo) {}

  public function createService(): FeesService
  {
    $repository = new DashboardRepository($this->pdo);

    return new FeesService($repository);
  }
}
