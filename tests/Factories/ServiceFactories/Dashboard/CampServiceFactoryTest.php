<?php

declare(strict_types=1);

namespace Tests\Factories\ServiceFactories\Dashboard;

use App\Factories\ServiceFactories\Dashboard\CampServiceFactory;
use App\Service\Dashboard\CampService;
use PDO;
use PHPUnit\Framework\TestCase;

class CampServiceFactoryTest extends TestCase
{
  public function testCreateServiceReturnsCorrectInstance(): void
  {
    $pdoMock = $this->createMock(PDO::class);

    $factory = new CampServiceFactory($pdoMock);
    $service = $factory->createService();

    $this->assertInstanceOf(CampService::class, $service);
  }
}
