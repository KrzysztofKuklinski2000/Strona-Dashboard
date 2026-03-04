<?php

declare(strict_types=1);

namespace Tests\Service\Dashboard;

use App\Repository\DashboardRepository;
use App\Service\Dashboard\SubscribersService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SubscriberServiceTest extends TestCase
{
  private DashboardRepository | MockObject $repository;
  private SubscribersService $service;

  protected function setUp(): void
  {
    $this->repository = $this->createMock(DashboardRepository::class);
    $this->service = new SubscribersService($this->repository);
  }

  public function testShouldGetAllSubscribers(): void
  {
    // GIVEN 
    $subscribers = [
      ['id' => 1, 'email' => 'example1@test.com'],
      ['id' => 2, 'email' => 'example2@test.com'],
    ];

    // EXPECTS 
    $this->repository->method('getDashboardData')
      ->with('subscribers')
      ->willReturn($subscribers);

    // WHEN 
    $actual = $this->service->getAllSubscribers();

    // THEN
    $this->assertEquals($subscribers, $actual);
  }
}