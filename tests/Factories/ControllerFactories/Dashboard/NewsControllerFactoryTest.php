<?php

namespace Tests\Factories\ControllerFactories\Dashboard;

use PDO;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use PHPUnit\Framework\TestCase;
use App\Controller\Dashboard\NewsController;
use App\Factories\ControllerFactories\Dashboard\NewsControllerFactory;

class NewsControllerFactoryTest extends TestCase
{
  public function testShouldCreateNewsControllerInstance(): void
  {
    // GIVEN
    $pdo = $this->createMock(PDO::class);

    $request = $this->createMock(Request::class);
    $csrf = $this->createMock(EasyCSRF::class);

    $factory = new NewsControllerFactory($pdo);

    // WHEN
    $controller = $factory->createController($request, $csrf);

    // THEN
    $this->assertInstanceOf(NewsController::class, $controller);
  }
}
