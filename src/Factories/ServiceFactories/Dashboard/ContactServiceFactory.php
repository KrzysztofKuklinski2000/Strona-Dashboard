<?php

namespace App\Factories\ServiceFactories\Dashboard;

use App\Factories\ServiceFactories\ServiceFactoryInterface;
use App\Repository\DashboardRepository;
use App\Service\Dashboard\ContactService;
use PDO;

class ContactServiceFactory implements ServiceFactoryInterface
{
  public function __construct(private PDO $pdo) {}

  public function createService(): ContactService
  {
    $repository = new DashboardRepository($this->pdo);

    return new ContactService($repository);
  }
}
