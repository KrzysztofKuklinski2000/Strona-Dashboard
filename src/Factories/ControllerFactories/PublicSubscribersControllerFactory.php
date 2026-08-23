<?php

namespace App\Factories\ControllerFactories;

use App\Controller\PublicSubscribersController;
use App\Core\ContextController;
use App\Factories\ServiceFactories\Notification\NotifierFactory;
use App\Factories\ServiceFactories\SubscriptionServiceFactory;
use PDO;

class PublicSubscribersControllerFactory implements ControllerFactoryInterface
{
    private SubscriptionServiceFactory $serviceFactory;

    public function __construct(private readonly PDO $pdo)
    {
        $this->serviceFactory = new SubscriptionServiceFactory($this->pdo);
    }

    public function createController(ContextController $contextController): PublicSubscribersController
    {
        $service = $this->serviceFactory->createService();

        $notifierFactory = new NotifierFactory($this->pdo, $contextController->config);
        $notifier = $notifierFactory->createService();

        return new PublicSubscribersController(
            $service,
            $notifier,
            $contextController,
        );
    }
}