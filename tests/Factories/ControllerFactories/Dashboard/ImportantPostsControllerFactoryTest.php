<?php

namespace Tests\Factories\ControllerFactories\Dashboard;

use PDO;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use PHPUnit\Framework\TestCase;
use App\Controller\Dashboard\ImportantPostsController;
use App\Factories\ControllerFactories\Dashboard\ImportantPostsControllerFactory;

class ImportantPostsControllerFactoryTest extends TestCase
{
  public function testShouldCreateImportantPostsControllerInstance(): void
  {
    // GIVEN
    $pdo = $this->createMock(PDO::class);

    $request = $this->createMock(Request::class);
    $csrf = $this->createMock(EasyCSRF::class);

    $factory = new ImportantPostsControllerFactory($pdo);

    // WHEN
    $controller = $factory->createController($request, $csrf);

    // THEN
    $this->assertInstanceOf(ImportantPostsController::class, $controller);
  }
}
