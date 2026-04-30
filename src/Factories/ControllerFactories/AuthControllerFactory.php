<?php
declare(strict_types=1);

namespace App\Factories\ControllerFactories;

use App\Core\ContextController;
use PDO;
use App\View;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Controller\AuthController;
use App\Middleware\CsrfMiddleware;
use App\Controller\AbstractController;
use App\Factories\ServiceFactories\AuthServiceFactory;
use App\Factories\ControllerFactories\ControllerFactoryInterface;

class AuthControllerFactory implements ControllerFactoryInterface
{
    private AuthServiceFactory $serviceFactory;


    public function __construct(PDO $pdo)
    {
        $this->serviceFactory = new AuthServiceFactory($pdo);
    }

    public function createController(ContextController $contextController): AbstractController
    {
        $authService = $this->serviceFactory->createService();

        return new AuthController(
            $authService,
            $contextController,
        );
    }
}