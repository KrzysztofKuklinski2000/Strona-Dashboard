<?php

namespace App\Factories\SecurityFactories;

use App\Factories\ServiceFactories\ServiceFactoryInterface;
use App\Repository\AuthRepository;
use App\Security\Authenticator;
use PDO;

class AuthenticationFactory implements ServiceFactoryInterface
{

    public function __construct(private PDO $pdo)
    {
    }

    public function createService()
    {
        $repository = new AuthRepository($this->pdo);
        return new Authenticator($repository);
    }
}
