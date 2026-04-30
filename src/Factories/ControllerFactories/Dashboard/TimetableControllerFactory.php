<?php

declare(strict_types=1);

namespace App\Factories\ControllerFactories\Dashboard;


use App\Controller\AbstractController;
use App\Controller\Dashboard\TimetableController;
use App\Core\ContextController;
use App\Core\Request;
use App\Factories\ControllerFactories\ControllerFactoryInterface;
use App\Factories\ServiceFactories\Dashboard\TimetableServiceFactory;
use App\Middleware\CsrfMiddleware;
use App\View;
use EasyCSRF\EasyCSRF;
use PDO;

class TimetableControllerFactory implements ControllerFactoryInterface
{
    private TimetableServiceFactory $serviceFactory;


    public function __construct(PDO $pdo)
    {
        $this->serviceFactory = new TimetableServiceFactory($pdo);
    }

    public function createController(ContextController $contextController): AbstractController
    {
        $timetableService = $this->serviceFactory->createService();

        return new TimetableController(
            $timetableService,
            $contextController
        );
    }
}
