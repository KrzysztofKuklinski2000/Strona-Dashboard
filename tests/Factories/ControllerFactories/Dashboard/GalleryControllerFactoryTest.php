<?php
namespace Tests\Factories\ControllerFactories\Dashboard;

use PDO;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use PHPUnit\Framework\TestCase;
use App\Controller\Dashboard\GalleryController;
use App\Factories\ControllerFactories\Dashboard\GalleryControllerFactory;

class GalleryControllerFactoryTest extends TestCase
{
  public function testShouldCreateGalleryControllerInstance(): void
  {
    // GIVEN
    $pdo = $this->createMock(PDO::class);

    $request = $this->createMock(Request::class);
    $csrf = $this->createMock(EasyCSRF::class);

    $factory = new GalleryControllerFactory($pdo);

    // WHEN
    $controller = $factory->createController($request, $csrf);

    // THEN
    $this->assertInstanceOf(GalleryController::class, $controller);
  }
}
