<?php

namespace App\Factories\ServiceFactories\Dashboard;

use App\Factories\ServiceFactories\ServiceFactoryInterface;
use App\Repository\Dashboard\ImportantPostsRepository;
use App\Service\Dashboard\ImportantPostsService;
use PDO;

class ImportantPostsServiceFactory implements ServiceFactoryInterface
{
  public function __construct(private PDO $pdo) {}

  public function createService(): ImportantPostsService
  {
    $repository = new ImportantPostsRepository($this->pdo);

    return new ImportantPostsService($repository);
  }
}
