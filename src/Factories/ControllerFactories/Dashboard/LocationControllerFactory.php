<?php

namespace App\Factories\ControllerFactories\Dashboard;

use App\Controller\Dashboard\LocationController;
use App\Core\ContextController;
use App\Factories\ControllerFactories\ControllerFactoryInterface;
use App\Factories\ServiceFactories\Dashboard\LocationServiceFactory;
use App\Mapper\Dashboard\DeleteRequestMapper;
use App\Mapper\Dashboard\LocationRequestMapper;
use App\Mapper\Dashboard\PublicationRequestMapper;
use PDO;

readonly class LocationControllerFactory implements ControllerFactoryInterface
{
    public function __construct(private PDO $pdo)
    {
    }

    public function createController(ContextController $contextController): LocationController {
        $service = (new LocationServiceFactory($this->pdo))->createService();

        $mapper = new LocationRequestMapper(
            $contextController->request,
            $contextController->validator,
            new DeleteRequestMapper(
                $contextController->request,
                $contextController->validator
            ),
            new PublicationRequestMapper(
                $contextController->request,
                $contextController->validator
            )
        );

        return new LocationController(
            $service,
            $mapper,
            $contextController
        );
    }
}