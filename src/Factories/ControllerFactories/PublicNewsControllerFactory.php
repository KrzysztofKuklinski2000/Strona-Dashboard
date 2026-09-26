<?php
declare(strict_types=1);

namespace App\Factories\ControllerFactories;

use App\Controller\AbstractController;
use App\Controller\PublicNewsController;
use App\Core\ContextController;
use App\Factories\ServiceFactories\ContactProviderFactory;
use App\Factories\ServiceFactories\PublicNewsServiceFactory;
use App\View\PublicPageRenderer;
use PDO;

class PublicNewsControllerFactory implements ControllerFactoryInterface
{
    public function __construct(private PDO $pdo)
    {
    }

    public function createController(ContextController $contextController): AbstractController
    {
        $serviceFactory = new PublicNewsServiceFactory($this->pdo, $contextController->config);
        $publicNewsService = $serviceFactory->createService();

        $contactProvider = (new ContactProviderFactory($this->pdo))->createService();

        $renderer = new PublicPageRenderer($contextController, $contactProvider);

        return new PublicNewsController (
            $publicNewsService,
            $renderer,
            $contextController,
        );
    }
}