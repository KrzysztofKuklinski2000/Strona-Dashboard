<?php

namespace App\Factories\ServiceFactories;

use App\Core\FileHandler;
use App\Repository\DashboardRepository;
use App\Service\Dashboard\DashboardService;

class DashboardServiceFactory implements ServiceFactoryInterface {

  public function __construct(private array $dbconfig){}

  public function createService() {
    
    $repository = new DashboardRepository($this->dbconfig);

    $fileHandler = new FileHandler();

    return new DashboardService($repository, $fileHandler);
  }
}