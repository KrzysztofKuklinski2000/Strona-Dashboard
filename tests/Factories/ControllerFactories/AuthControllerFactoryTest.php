<?php 

namespace Tests\Factories\ControllerFactories;

use PDO;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use PHPUnit\Framework\TestCase;
use App\Controller\AuthController;
use App\Factories\ControllerFactories\AuthControllerFactory;

class AuthControllerFactoryTest extends TestCase  
{
  public function testShouldCreateAuthControllerInstance(): void
  {
    // GIVEN
    $pdo = $this->createMock(PDO::class);

    $request = $this->createMock(Request::class);
    $csrf = $this->createMock(EasyCSRF::class); 
    $factory = new AuthControllerFactory($pdo);

    // WHEN
    $controller = $factory->createController($request, $csrf);
    
    // THEN
    $this->assertInstanceOf(AuthController::class, $controller);
  }
}
