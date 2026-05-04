<?php

namespace App\Factories\ServiceFactories\Dashboard;

use App\Core\Config;
use App\Core\FileHandler;
use App\Factories\ServiceFactories\ServiceFactoryInterface;
use App\Repository\Dashboard\GalleryRepository;
use App\Service\Dashboard\GalleryService;
use PDO;

readonly class GalleryServiceFactory implements ServiceFactoryInterface
{
  public function __construct(private PDO $pdo, private Config $config) {}

  public function createService(): GalleryService
  {
    $fileHandler = new FileHandler($this->config->getUploadDir());
    $repository = new GalleryRepository($this->pdo);

    return new GalleryService($repository, $fileHandler);
  }
}
