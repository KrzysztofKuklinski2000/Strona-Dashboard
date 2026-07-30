<?php

declare(strict_types=1);

namespace App\Factories\ControllerFactories\Dashboard;


use App\Controller\AbstractController;
use App\Controller\Dashboard\NewsController;
use App\Core\ContextController;
use App\Factories\ControllerFactories\ControllerFactoryInterface;
use App\Factories\ServiceFactories\Dashboard\NewsServiceFactory;
use App\Mapper\Dashboard\PublicationRequestMapper;
use PDO;

class NewsControllerFactory implements ControllerFactoryInterface
{
    private NewsServiceFactory $serviceFactory;

    public function __construct(PDO $pdo)
    {
        $this->serviceFactory = new NewsServiceFactory($pdo);
    }

    public function createController(ContextController $contextController): AbstractController
    {
        $service = $this->serviceFactory->createService();

        $publicationRequestMapper = new PublicationRequestMapper(
            $contextController->request,
            $contextController->validator,
        );

        return new NewsController(
            $service,
            $publicationRequestMapper,
            $contextController
        );
    }
}
