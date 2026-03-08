<?php

namespace Tests\Factories\ControllerFactories;

use App\Controller\PublicSubscribersController;
use App\Core\Request;
use App\Factories\ControllerFactories\PublicSubscribersControllerFactory;
use EasyCSRF\EasyCSRF;
use PDO;
use PHPUnit\Framework\TestCase;

class PublicSubscribersControllerFactoryTest extends TestCase
{
  public function testShouldCreateSiteControllerInstance(): void
  {
    // GIVEN
    $pdo = $this->createMock(PDO::class);

    $request = $this->createMock(Request::class);
    $csrf = $this->createMock(EasyCSRF::class);

    $factory = new PublicSubscribersControllerFactory($pdo);

    // WHEN
    $controller = $factory->createController($request, $csrf);

    // THEN
    $this->assertInstanceOf(PublicSubscribersController::class, $controller);
  }
}
