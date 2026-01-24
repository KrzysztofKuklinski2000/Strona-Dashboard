<?php

namespace Tests\Factories\ServiceFactories;

use PDO;
use PHPUnit\Framework\TestCase;
use App\Service\Dashboard\DashboardService;
use App\Factories\ServiceFactories\DashboardServiceFactory;

class DashboardServiceFactoryTest extends TestCase {
  
  public function testShouldCreateDashboardServiceInstance(): void
  {
    // GIVEN
    $pdo = $this->createMock(PDO::class);

    $factory = new DashboardServiceFactory($pdo);

    // WHEN 
    $actual = $factory->createService();

    //THEN 
    $this->assertInstanceOf(DashboardService::class, $actual);
  }
}