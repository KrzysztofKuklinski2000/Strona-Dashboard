<?php

namespace Tests\Factories\ControllerFactories;

use PDO;
use PHPUnit\Framework\TestCase;
use App\Factories\ControllerFactories\SiteControllerFactory;
use App\Controller\SiteController;
use App\Core\Request;
use EasyCSRF\EasyCSRF;

class SiteControllerFactoryTest extends TestCase
{
  public function testShouldCreateSiteControllerInstance(): void
  {
    // GIVEN
    $pdo = $this->createMock(PDO::class);

    $request = $this->createMock(Request::class);
    $csrf = $this->createMock(EasyCSRF::class);

    $factory = new SiteControllerFactory($pdo);

    // WHEN
    $controller = $factory->createController($request, $csrf);

    // THEN
    $this->assertInstanceOf(SiteController::class, $controller);
  }
}
