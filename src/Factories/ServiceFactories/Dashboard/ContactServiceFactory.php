<?php

namespace App\Factories\ServiceFactories\Dashboard;

use App\Factories\ServiceFactories\ServiceFactoryInterface;
use App\Repository\Dashboard\ContactRepository;
use App\Service\Dashboard\ContactService;
use PDO;

class ContactServiceFactory implements ServiceFactoryInterface
{
  public function __construct(private PDO $pdo) {}

  public function createService(): ContactService
  {
    $repository = new ContactRepository($this->pdo);

    return new ContactService($repository);
  }
}
