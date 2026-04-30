<?php

namespace App\Factories\ControllerFactories;

use App\Controller\PublicSubscribersController;
use App\Core\ContextController;
use App\Factories\ServiceFactories\Dashboard\SubscribersServiceFactory;
use App\Middleware\CsrfMiddleware;
use App\Core\Request;
use App\Factories\ServiceFactories\Notification\NotifierFactory;
use App\View;
use EasyCSRF\EasyCSRF;
use PDO;

class PublicSubscribersControllerFactory implements ControllerFactoryInterface
{
    private SubscribersServiceFactory $serviceFactory;

    public function __construct(private PDO $pdo)
    {
        $this->serviceFactory = new SubscribersServiceFactory($this->pdo);
    }

    public function createController(ContextController $contextController): PublicSubscribersController
    {
        $service = $this->serviceFactory->createService();

        $notifierFactory = new NotifierFactory($this->pdo);
        $notifier = $notifierFactory->createService();

        return new PublicSubscribersController(
            $service,
            $notifier,
            $contextController,
        );
    }
}