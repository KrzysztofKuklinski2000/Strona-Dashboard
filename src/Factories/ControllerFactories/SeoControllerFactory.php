<?php

declare(strict_types=1);

namespace App\Factories\ControllerFactories;

use App\Controller\AbstractController;
use App\Controller\SeoController;
use App\Core\ContextController;
use App\Repository\PublicNewsRepository;
use App\Service\SitemapService;
use PDO;

final readonly class SeoControllerFactory implements ControllerFactoryInterface
{
    public function __construct(private PDO $pdo)
    {
    }

    public function createController(ContextController $contextController): AbstractController
    {
        $service = new SitemapService(
            new PublicNewsRepository($this->pdo),
            $contextController->config->getUrl(),
            $contextController->config->getItemsPerPage(),
        );

        return new SeoController($service, $contextController);
    }
}
