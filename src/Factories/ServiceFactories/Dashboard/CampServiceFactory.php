<?php

namespace App\Factories\ServiceFactories\Dashboard;

use App\Factories\ServiceFactories\ServiceFactoryInterface;
use App\Repository\DashboardRepository;
use App\Service\Dashboard\CampService;
use PDO;

class CampServiceFactory implements ServiceFactoryInterface
{
  public function __construct(private PDO $pdo){}

  public function createService(): CampService
  {
    $repository = new DashboardRepository($this->pdo);

    return new CampService($repository);
  }
}