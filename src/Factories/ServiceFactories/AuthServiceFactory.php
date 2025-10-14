<?php

namespace App\Factories\ServiceFactories;

use App\Service\AuthService;
use App\Repository\AuthRepository;

class AuthServiceFactory implements ServiceFactoryInterface {

  public function __construct(private array $dbconfig) {}

  public function createService() {
    $repository = new AuthRepository($this->dbconfig);
    return new AuthService($repository);
  }
}
