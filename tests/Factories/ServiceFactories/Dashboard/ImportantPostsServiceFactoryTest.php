<?php

declare(strict_types=1);

namespace Tests\Factories\ServiceFactories\Dashboard;

use App\Factories\ServiceFactories\Dashboard\ImportantPostsServiceFactory;
use App\Service\Dashboard\ImportantPostsService;
use PDO;
use PHPUnit\Framework\TestCase;

class ImportantPostsServiceFactoryTest extends TestCase
{
  public function testCreateServiceReturnsCorrectInstance(): void
  {
    $pdoMock = $this->createMock(PDO::class);

    $factory = new ImportantPostsServiceFactory($pdoMock);
    $service = $factory->createService();

    $this->assertInstanceOf(ImportantPostsService::class, $service);
  }
}
