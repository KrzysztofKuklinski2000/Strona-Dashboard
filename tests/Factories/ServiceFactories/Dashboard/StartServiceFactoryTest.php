<?php

declare(strict_types=1);

namespace Tests\Factories\ServiceFactories\Dashboard;

use App\Factories\ServiceFactories\Dashboard\StartServiceFactory;
use App\Service\Dashboard\StartService;
use PDO;
use PHPUnit\Framework\TestCase;

class StartServiceFactoryTest extends TestCase
{
  public function testCreateServiceReturnsCorrectInstance(): void
  {
    $pdoMock = $this->createMock(PDO::class);

    $factory = new StartServiceFactory($pdoMock);
    $service = $factory->createService();

    $this->assertInstanceOf(StartService::class, $service);
  }
}
