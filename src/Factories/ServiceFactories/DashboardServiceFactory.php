<?php

namespace App\Factories\ServiceFactories;

use App\Service\Dashboard\DashboardService;
use App\Repository\DashboardRepository;

class DashboardServiceFactory implements ServiceFactoryInterface {

  public function __construct(private array $dbconfig){}

  public function createService() {
    
    $repository = new DashboardRepository($this->dbconfig);
    return new DashboardService($repository);
  }
}