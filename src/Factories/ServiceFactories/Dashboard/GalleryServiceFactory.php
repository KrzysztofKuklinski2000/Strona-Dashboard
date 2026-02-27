<?php

namespace App\Factories\ServiceFactories\Dashboard;

use App\Core\FileHandler;
use App\Factories\ServiceFactories\ServiceFactoryInterface;
use App\Repository\DashboardRepository;
use App\Service\Dashboard\GalleryService;
use PDO;

class GalleryServiceFactory implements ServiceFactoryInterface
{
  public function __construct(private PDO $pdo) {}

  public function createService(): GalleryService
  {
    $fileHandler = new FileHandler();
    $repository = new DashboardRepository($this->pdo);

    return new GalleryService($repository, $fileHandler);
  }
}
