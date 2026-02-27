<?php

declare(strict_types=1);

namespace Tests\Factories\ServiceFactories\Dashboard;

use App\Factories\ServiceFactories\Dashboard\ContactServiceFactory;
use App\Service\Dashboard\ContactService;
use PDO;
use PHPUnit\Framework\TestCase;

class ContactServiceFactoryTest extends TestCase
{
  public function testCreateServiceReturnsCorrectInstance(): void
  {
    $pdoMock = $this->createMock(PDO::class);

    $factory = new ContactServiceFactory($pdoMock);
    $service = $factory->createService();

    $this->assertInstanceOf(ContactService::class, $service);
  }
}
