<?php

declare(strict_types=1);

namespace Tests\Factories\ServiceFactories\Dashboard;

use App\Factories\ServiceFactories\Dashboard\FeesServiceFactory;
use App\Service\Dashboard\FeesService;
use PDO;
use PHPUnit\Framework\TestCase;

class FeesServiceFactoryTest extends TestCase
{
  public function testCreateServiceReturnsCorrectInstance(): void
  {
    $pdoMock = $this->createMock(PDO::class);

    $factory = new FeesServiceFactory($pdoMock);
    $service = $factory->createService();

    $this->assertInstanceOf(FeesService::class, $service);
  }
}
