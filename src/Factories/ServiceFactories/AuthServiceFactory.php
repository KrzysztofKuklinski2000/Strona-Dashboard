<?php

namespace App\Factories\ServiceFactories;

use PDO;
use App\Service\AuthService;
use App\Repository\AuthRepository;

class AuthServiceFactory implements ServiceFactoryInterface {

  public function __construct(private PDO $pdo) {}

  public function createService() {
    $repository = new AuthRepository($this->pdo);
    return new AuthService($repository);
  }
}
