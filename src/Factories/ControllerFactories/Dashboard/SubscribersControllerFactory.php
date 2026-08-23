<?php

declare(strict_types=1);

namespace App\Factories\ControllerFactories\Dashboard;

use App\Controller\AbstractController;
use App\Controller\Dashboard\SubscribersController;
use App\Core\ContextController;
use App\Factories\ControllerFactories\ControllerFactoryInterface;
use App\Factories\ServiceFactories\Dashboard\SubscribersServiceFactory;
use App\Mapper\Dashboard\DeleteRequestMapper;
use App\Mapper\Dashboard\SubscriberRequestMapper;
use PDO;

class SubscribersControllerFactory implements ControllerFactoryInterface
{
    private SubscribersServiceFactory $serviceFactory;

    public function __construct(PDO $pdo)
    {
        $this->serviceFactory = new SubscribersServiceFactory($pdo);
    }

    public function createController(ContextController $contextController): AbstractController
    {
        $service = $this->serviceFactory->createService();
        $subscriberRequestMapper = new SubscriberRequestMapper(
            $contextController->request,
            $contextController->validator,
            new DeleteRequestMapper(
                $contextController->request,
                $contextController->validator,
            )
        );

        return new SubscribersController(
            $service,
            $subscriberRequestMapper,
            $contextController
        );
    }
}
