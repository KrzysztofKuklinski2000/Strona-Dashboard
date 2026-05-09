<?php
declare(strict_types=1);

namespace App\Factories\ControllerFactories;

use App\Controller\AbstractController;
use App\Controller\AuthController;
use App\Core\ContextController;
use App\Factories\SecurityFactories\AuthenticationFactory;
use PDO;

class AuthControllerFactory implements ControllerFactoryInterface
{
    private AuthenticationFactory $authenticationFactory;


    public function __construct(PDO $pdo)
    {
        $this->authenticationFactory = new AuthenticationFactory($pdo);
    }

    public function createController(ContextController $contextController): AbstractController
    {
        $authentication = $this->authenticationFactory->createService();

        return new AuthController(
            $authentication,
            $contextController,
        );
    }
}