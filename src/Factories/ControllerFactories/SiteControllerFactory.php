<?php
declare(strict_types=1);

namespace App\Factories\ControllerFactories;


use App\Controller\AbstractController;
use App\Controller\SiteController;
use App\Core\ContextController;
use App\Factories\ServiceFactories\SiteServiceFactory;
use PDO;

class SiteControllerFactory implements ControllerFactoryInterface
{
    private SiteServiceFactory $serviceFactory;

    public function __construct(PDO $pdo)
    {
        $this->serviceFactory = new SiteServiceFactory($pdo);
    }

    public function createController(ContextController $contextController): AbstractController
    {
        $siteService = $this->serviceFactory->createService();


        return new SiteController(
            $siteService,
            $contextController
        );
    }
}