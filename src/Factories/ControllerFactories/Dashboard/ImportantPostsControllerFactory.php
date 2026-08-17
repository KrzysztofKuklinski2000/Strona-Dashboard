<?php

declare(strict_types=1);

namespace App\Factories\ControllerFactories\Dashboard;


use App\Controller\AbstractController;
use App\Controller\Dashboard\ImportantPostsController;
use App\Core\ContextController;
use App\Factories\ControllerFactories\ControllerFactoryInterface;
use App\Factories\ServiceFactories\Dashboard\ImportantPostsServiceFactory;
use App\Mapper\Dashboard\ChangePositionRequestMapper;
use App\Mapper\Dashboard\DeleteRequestMapper;
use App\Mapper\Dashboard\ImportantPostsRequestMapper;
use App\Mapper\Dashboard\PublicationRequestMapper;
use PDO;

class ImportantPostsControllerFactory implements ControllerFactoryInterface
{
    private ImportantPostsServiceFactory $serviceFactory;

    public function __construct(PDO $pdo)
    {
        $this->serviceFactory = new ImportantPostsServiceFactory($pdo);
    }

    public function createController(ContextController $contextController): AbstractController
    {
        $service = $this->serviceFactory->createService();

        $requestMapper = new ImportantPostsRequestMapper(
            $contextController->request,
            $contextController->validator,
            new ChangePositionRequestMapper(
                $contextController->request,
                $contextController->validator,
            ),
            new PublicationRequestMapper(
                $contextController->request,
                $contextController->validator,
            ),
            new DeleteRequestMapper(
                $contextController->request,
                $contextController->validator,
            )
        );

        return new ImportantPostsController(
            $service,
            $requestMapper,
            $contextController,
        );
    }
}
