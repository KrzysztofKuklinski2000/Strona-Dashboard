<?php

namespace App\Factories\ServiceFactories\Dashboard;

use App\Factories\ServiceFactories\ServiceFactoryInterface;
use App\Repository\Dashboard\CampRepository;
use App\Service\Dashboard\CampService;
use PDO;

readonly class CampServiceFactory implements ServiceFactoryInterface
{
  public function __construct(private PDO $pdo){}

  public function createService(): CampService
  {
    $repository = new CampRepository($this->pdo);

    return new CampService($repository);
  }
}