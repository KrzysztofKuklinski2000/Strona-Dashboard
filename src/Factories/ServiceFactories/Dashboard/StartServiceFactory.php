<?php

namespace App\Factories\ServiceFactories\Dashboard;

use App\Core\Config;
use App\Core\FileHandler;
use App\Factories\ServiceFactories\ServiceFactoryInterface;
use App\Repository\Dashboard\StartRepository;
use App\Service\Dashboard\StartService;
use PDO;

readonly class StartServiceFactory implements ServiceFactoryInterface
{
  public function __construct(private PDO $pdo, private Config $config) {}

  public function createService(): StartService
  {
    $repository = new StartRepository($this->pdo);
    $fileHandler = new FileHandler($this->config->getUploadDir(), $this->config->getFilePrefix());


      return new StartService($repository, $fileHandler, $this->config->getUploadUrl());
  }
}
