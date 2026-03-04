<?php

namespace Tests\Factories\ControllerFactories\Dashboard;

use App\Controller\Dashboard\SubscribersController;
use App\Core\Request;
use App\Factories\ControllerFactories\Dashboard\SubscribersControllerFactory;
use EasyCSRF\EasyCSRF;
use PDO;
use PHPUnit\Framework\TestCase;

class SubscribersControllerFactoryTest extends TestCase
{
  public function testShouldCreateSubscribersControllerInstance(): void
  {
    // GIVEN
    $pdo = $this->createMock(PDO::class);

    $request = $this->createMock(Request::class);
    $csrf = $this->createMock(EasyCSRF::class);

    $factory = new SubscribersControllerFactory($pdo);

    // WHEN
    $controller = $factory->createController($request, $csrf);

    // THEN
    $this->assertInstanceOf(SubscribersController::class, $controller);
  }
}
