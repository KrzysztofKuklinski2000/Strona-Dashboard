<?php
declare(strict_types=1);

namespace App\Factories\ControllerFactories;

use App\Controller\AbstractController;
use App\Controller\SiteController;
use App\Core\ContextController;
use App\Factories\ServiceFactories\SiteServiceFactory;
use App\View\PublicPageRenderer;
use PDO;

readonly class SiteControllerFactory implements ControllerFactoryInterface
{
    public function __construct(private PDO $pdo)
    {
    }

    public function createController(ContextController $contextController): AbstractController
    {
        $serviceFactory = new SiteServiceFactory($this->pdo, $contextController->config);
        $siteService = $serviceFactory->createService();

        $renderer = new PublicPageRenderer($contextController, $siteService);

        return new SiteController(
            $siteService,
            $contextController,
            $renderer
        );
    }
}