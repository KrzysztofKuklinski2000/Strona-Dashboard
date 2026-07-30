<?php

declare(strict_types=1);

namespace App\Factories\ControllerFactories\Dashboard;

use App\Controller\AbstractController;
use App\Controller\Dashboard\StartController;
use App\Core\ContextController;
use App\Factories\ControllerFactories\ControllerFactoryInterface;
use App\Factories\ServiceFactories\Dashboard\StartServiceFactory;
use App\Mapper\Dashboard\MainPage\MainPagePayloadNormalizer;
use App\Mapper\Dashboard\MainPage\MainPagePostRequestMapper;
use App\Mapper\Dashboard\PublicationRequestMapper;
use PDO;

class StartControllerFactory implements ControllerFactoryInterface
{
    public function __construct(private PDO $pdo)
    {

    }

    public function createController(ContextController $contextController): AbstractController
    {
        $serviceFactory = new StartServiceFactory($this->pdo, $contextController->config);
        $service = $serviceFactory->createService();

        $payloadNormalizer = new MainPagePayloadNormalizer($contextController->validator);

        $requestMapper = new MainPagePostRequestMapper(
            $contextController->request,
            $contextController->validator,
            $contextController->config,
            $payloadNormalizer
        );

        $publicationRequestMapper = new PublicationRequestMapper(
            $contextController->request,
            $contextController->validator,
        );

        return new StartController(
            $service,
            $requestMapper,
            $publicationRequestMapper,
            $contextController,
        );
    }
}
