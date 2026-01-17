<?php

namespace App\Factories\ServiceFactories;

use PDO;
use App\Core\FileHandler;
use App\Repository\DashboardRepository;
use App\Service\Dashboard\DashboardService;

class DashboardServiceFactory implements ServiceFactoryInterface {

  public function __construct(private PDO $pdo){}

  public function createService() {
    
    $repository = new DashboardRepository($this->pdo);

    $fileHandler = new FileHandler();

    return new DashboardService($repository, $fileHandler);
  }
}