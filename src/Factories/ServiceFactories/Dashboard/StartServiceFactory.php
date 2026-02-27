<?php

namespace App\Factories\ServiceFactories\Dashboard;

use App\Factories\ServiceFactories\ServiceFactoryInterface;
use App\Repository\DashboardRepository;
use App\Service\Dashboard\StartService;
use PDO;

class StartServiceFactory implements ServiceFactoryInterface
{
  public function __construct(private PDO $pdo) {}

  public function createService(): StartService
  {
    $repository = new DashboardRepository($this->pdo);

    return new StartService($repository);
  }
}
