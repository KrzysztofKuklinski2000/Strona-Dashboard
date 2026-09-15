<?php
declare(strict_types=1);

namespace App\Factories\ControllerFactories\Dashboard;

use App\Controller\AbstractController;
use App\Controller\Dashboard\OverviewController;
use App\Core\ContextController;
use App\Factories\ControllerFactories\ControllerFactoryInterface;

class OverviewControllerFactory implements ControllerFactoryInterface
{
    public function createController(ContextController $contextController): AbstractController
    {
        return new OverviewController($contextController);
    }
}