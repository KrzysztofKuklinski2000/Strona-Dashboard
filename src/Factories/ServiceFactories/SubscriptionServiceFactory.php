<?php

namespace App\Factories\ServiceFactories;

use App\Repository\Dashboard\SubscriberRepository;
use App\Security\TokenGenerator;

use App\Service\SubscriptionService;
use PDO;

class SubscriptionServiceFactory implements ServiceFactoryInterface
{
    public function __construct(private PDO $pdo) {}

    public function createService(): SubscriptionService
    {
        $repository = new SubscriberRepository($this->pdo);
        $tokenGenerator = new TokenGenerator();

        return new SubscriptionService($repository, $tokenGenerator);
    }
}
