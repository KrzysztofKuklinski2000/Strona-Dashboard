<?php

declare(strict_types=1);

namespace App\Factories\ServiceFactories;

use App\Core\Config;
use App\Factories\ServiceFactories\Notification\NotifierFactory;
use App\Repository\Dashboard\SubscriberRepository;
use App\Security\TokenGenerator;
use App\Service\SubscriptionService;
use PDO;

readonly class SubscriptionServiceFactory implements ServiceFactoryInterface
{
    public function __construct(
        private PDO    $pdo,
        private Config $config
    ) {
    }

    public function createService(): SubscriptionService
    {
        $repository = new SubscriberRepository($this->pdo);
        $tokenGenerator = new TokenGenerator();

        $notifierFactory = new NotifierFactory(
            $this->pdo,
            $this->config
        );

        $notifier = $notifierFactory->createService();

        return new SubscriptionService(
            $repository,
            $tokenGenerator,
            $notifier
        );
    }
}
