<?php
declare(strict_types=1);

namespace App\Factories\ControllerFactories\Dashboard;

use App\Controller\AbstractController;
use App\Controller\Dashboard\GalleryCategoryController;
use App\Core\ContextController;
use App\Factories\ControllerFactories\ControllerFactoryInterface;
use App\Factories\ServiceFactories\Dashboard\GalleryCategoryServiceFactory;
use PDO;

readonly class GalleryCategoryControllerFactory implements ControllerFactoryInterface
{
    public function __construct(private PDO $pdo)
    {
    }

    public function createController(ContextController $contextController): AbstractController
    {
        $service = (new GalleryCategoryServiceFactory($this->pdo))->createService();

        return new GalleryCategoryController(
            $service,
            $contextController
        );
    }
}