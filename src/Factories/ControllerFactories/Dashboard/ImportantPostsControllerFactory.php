<?php

declare(strict_types=1);

namespace App\Factories\ControllerFactories\Dashboard;


use App\Controller\AbstractController;
use App\Controller\Dashboard\ImportantPostsController;
use App\Core\ContextController;
use App\Factories\ControllerFactories\ControllerFactoryInterface;
use App\Factories\ServiceFactories\Dashboard\ImportantPostsServiceFactory;
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


        return new ImportantPostsController(
            $service,
            $contextController,
        );
    }
}
