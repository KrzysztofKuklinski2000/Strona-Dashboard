<?php

declare(strict_types=1);

namespace Tests\Factories\ServiceFactories\Dashboard;

use App\Factories\ServiceFactories\Dashboard\GalleryServiceFactory;
use App\Service\Dashboard\GalleryService;
use PDO;
use PHPUnit\Framework\TestCase;

class GalleryServiceFactoryTest extends TestCase
{
  public function testCreateServiceReturnsCorrectInstance(): void
  {
    $pdoMock = $this->createMock(PDO::class);

    $factory = new GalleryServiceFactory($pdoMock);
    $service = $factory->createService();

    $this->assertInstanceOf(GalleryService::class, $service);
  }
}
