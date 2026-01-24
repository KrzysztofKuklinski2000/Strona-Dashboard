<?php

namespace Tests\Factories\ServiceFactories;

use PDO;
use App\Service\AuthService;
use PHPUnit\Framework\TestCase;
use App\Factories\ServiceFactories\AuthServiceFactory;

class AuthServiceFactoryTest extends TestCase 
{
  
  public function testShouldCreateAuthServiceInstance(): void 
  {
    // GIVEN
    $pdo = $this->createMock(PDO::class);

    $factory = new AuthServiceFactory($pdo);

    // WHEN 
    $actual = $factory->createService();

    //THEN 
    $this->assertInstanceOf(AuthService::class, $actual);
  }
}