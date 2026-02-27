<?php

declare(strict_types=1);

namespace Tests\Factories\ServiceFactories\Dashboard;

use App\Factories\ServiceFactories\Dashboard\NewsServiceFactory;
use App\Service\Dashboard\NewsService;
use PDO;
use PHPUnit\Framework\TestCase;

class NewsServiceFactoryTest extends TestCase
{
  public function testCreateServiceReturnsCorrectInstance(): void
  {
    $pdoMock = $this->createMock(PDO::class);

    $factory = new NewsServiceFactory($pdoMock);
    $service = $factory->createService();

    $this->assertInstanceOf(NewsService::class, $service);
  }
}
