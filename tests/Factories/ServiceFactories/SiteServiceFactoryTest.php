<?php

namespace Tests\Factories\ServiceFactories;

use PDO;
use App\Service\SiteService;
use PHPUnit\Framework\TestCase;
use App\Factories\ServiceFactories\SiteServiceFactory;

class SiteServiceFactoryTest extends TestCase
{
  public function testShouldCreateSiteServiceInstance(): void
  {
    // GIVEN
    $pdo = $this->createMock(PDO::class);

    $factory = new SiteServiceFactory($pdo);

    // WHEN 
    $actual = $factory->createService();

    //THEN 
    $this->assertInstanceOf(SiteService::class, $actual);

  }
}
