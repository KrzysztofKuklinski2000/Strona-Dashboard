<?php

namespace App\Factories\ServiceFactories\Dashboard;

use App\Factories\ServiceFactories\ServiceFactoryInterface;
use App\Repository\Dashboard\StartRepository;
use App\Service\Dashboard\StartService;
use PDO;

class StartServiceFactory implements ServiceFactoryInterface
{
  public function __construct(private readonly PDO $pdo) {}

  public function createService(): StartService
  {
    $repository = new StartRepository($this->pdo);

    return new StartService($repository);
  }
}
