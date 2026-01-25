<?php

namespace Tests\Factories\ControllerFactories\Dashboard;

use PDO;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use PHPUnit\Framework\TestCase;
use App\Controller\Dashboard\TimetableController;
use App\Factories\ControllerFactories\Dashboard\TimetableControllerFactory;

class TimetableControllerFactoryTest extends TestCase
{
  public function testShouldCreateTimetableControllerInstance(): void
  {
    // GIVEN
    $pdo = $this->createMock(PDO::class);

    $request = $this->createMock(Request::class);
    $csrf = $this->createMock(EasyCSRF::class);

    $factory = new TimetableControllerFactory($pdo);

    // WHEN
    $controller = $factory->createController($request, $csrf);

    // THEN
    $this->assertInstanceOf(TimetableController::class, $controller);
  }
}
