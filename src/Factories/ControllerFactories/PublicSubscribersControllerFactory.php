<?php

namespace App\Factories\ControllerFactories;

use App\Controller\PublicSubscribersController;
use App\Core\ContextController;
use App\Factories\ServiceFactories\SubscriptionServiceFactory;
use PDO;

readonly class PublicSubscribersControllerFactory implements ControllerFactoryInterface
{

    public function __construct(private PDO $pdo)
    {
    }

    public function createController(ContextController $contextController): PublicSubscribersController
    {
        $serviceFactory = new SubscriptionServiceFactory(
            $this->pdo,
            $contextController->config
        );

        $service = $serviceFactory->createService();

        return new PublicSubscribersController(
            $service,
            $contextController,
        );
    }
}