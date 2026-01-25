<?php

namespace Tests\Factories\ControllerFactories\Dashboard;

use PDO;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use PHPUnit\Framework\TestCase;
use App\Controller\Dashboard\FeesController;
use App\Factories\ControllerFactories\Dashboard\FeesControllerFactory;

class FeesControllerFactoryTest extends TestCase
{
  public function testShouldCreateFeesControllerInstance(): void
  {
    // GIVEN
    $pdo = $this->createMock(PDO::class);

    $request = $this->createMock(Request::class);
    $csrf = $this->createMock(EasyCSRF::class);

    $factory = new FeesControllerFactory($pdo);

    // WHEN
    $controller = $factory->createController($request, $csrf);

    // THEN
    $this->assertInstanceOf(FeesController::class, $controller);
  }
}
