<?php

namespace App\Factories\ServiceFactories\Dashboard;

use App\Factories\ServiceFactories\ServiceFactoryInterface;
use App\Repository\Dashboard\SubscriberRepository;
use App\Security\TokenGenerator;
use App\Service\Dashboard\SubscribersService;
use PDO;

class SubscribersServiceFactory implements ServiceFactoryInterface
{
  public function __construct(private PDO $pdo) {}

  public function createService(): SubscribersService
  {
    $repository = new SubscriberRepository($this->pdo);
    $tokenGenerator = new TokenGenerator();

    return new SubscribersService($repository, $tokenGenerator);
  }
}
