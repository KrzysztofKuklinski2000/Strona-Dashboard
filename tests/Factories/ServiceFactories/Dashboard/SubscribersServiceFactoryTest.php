<?php

declare(strict_types=1);

namespace Tests\Factories\ServiceFactories\Dashboard;

use App\Factories\ServiceFactories\Dashboard\SubscribersServiceFactory;
use App\Service\Dashboard\SubscribersService;
use PDO;
use PHPUnit\Framework\TestCase;

class SubscribersServiceFactoryTest extends TestCase
{
  public function testCreateServiceReturnsCorrectInstance(): void
  {
    $pdoMock = $this->createMock(PDO::class);

    $factory = new SubscribersServiceFactory($pdoMock);
    $service = $factory->createService();

    $this->assertInstanceOf(SubscribersService::class, $service);
  }
}
