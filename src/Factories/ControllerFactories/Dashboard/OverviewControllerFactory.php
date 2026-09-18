<?php
declare(strict_types=1);

namespace App\Factories\ControllerFactories\Dashboard;

use App\Controller\AbstractController;
use App\Controller\Dashboard\OverviewController;
use App\Core\ContextController;
use App\Factories\ControllerFactories\ControllerFactoryInterface;
use App\Factories\ServiceFactories\Dashboard\OverviewServiceFactory;
use PDO;

readonly class OverviewControllerFactory implements ControllerFactoryInterface
{
    public function __construct(private PDO $pdo)
    {
    }

    public function createController(ContextController $contextController): AbstractController
    {
        $service = (new OverviewServiceFactory($this->pdo))->createService();

        return new OverviewController(
            $service,
            $contextController
        );
    }
}