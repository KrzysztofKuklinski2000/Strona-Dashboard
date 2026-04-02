<?php

namespace App\Factories\ServiceFactories\Dashboard;

use App\Factories\ServiceFactories\ServiceFactoryInterface;
use App\Repository\Dashboard\FeesRepository;
use App\Service\Dashboard\FeesService;
use PDO;

readonly class FeesServiceFactory implements ServiceFactoryInterface
{
  public function __construct(private PDO $pdo) {}

  public function createService(): FeesService
  {
    $repository = new FeesRepository($this->pdo);

    return new FeesService($repository);
  }
}
