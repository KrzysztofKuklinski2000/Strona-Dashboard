<?php

declare(strict_types=1);

namespace Tests\Factories\ServiceFactories\Dashboard;

use App\Factories\ServiceFactories\Dashboard\TimetableServiceFactory;
use App\Service\Dashboard\TimetableService;
use PHPUnit\Framework\TestCase;
use PDO;

class TimetableServiceFactoryTest extends TestCase
{
  public function testCreateServiceReturnsCorrectInstance(): void
  {
    $pdoMock = $this->createMock(PDO::class);

    $factory = new TimetableServiceFactory($pdoMock);
    $service = $factory->createService();

    $this->assertInstanceOf(TimetableService::class, $service);
  }
}
