<?php

namespace Tests\Factories\ControllerFactories\Dashboard;

use PDO;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use PHPUnit\Framework\TestCase;
use App\Controller\Dashboard\CampController;
use App\Factories\ControllerFactories\Dashboard\CampControllerFactory;

class CampControllerFactoryTest extends TestCase
{
  public function testShouldCreateCampControllerInstance(): void
  {
    // GIVEN

    $pdo = $this->createMock(PDO::class);

    $request = $this->createMock(Request::class);
    $csrf = $this->createMock(EasyCSRF::class);

    $factory = new CampControllerFactory($pdo);

    // WHEN
    $controller = $factory->createController($request, $csrf);  

    // THEN
    $this->assertInstanceOf(CampController::class, $controller);
  }
}