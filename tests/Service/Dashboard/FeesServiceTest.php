<?php

namespace Tests\Service\Dashboard;

use App\Repository\DashboardRepository;
use App\Service\Dashboard\FeesService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class FeesServiceTest extends TestCase
{

  private DashboardRepository | MockObject $repository;
  private FeesService $service;

  protected function setUp(): void
  {
    $this->repository = $this->createMock(DashboardRepository::class);
    $this->service = new FeesService($this->repository);
  }

  public function testShouldGetFeesAndReturnFirstElement(): void
  {
    $fees = [['amount' => 100]];
    $this->repository->expects($this->once())->method('getDashboardData')->with('fees')->willReturn($fees);
    $this->assertEquals(['amount' => 100], $this->service->getFees());
  }

  public function testShouldUpdateFees(): void
  {
    $data = ['amount' => 100];
    $this->repository->expects($this->once())->method('edit')->with('fees', $data);
    $this->service->updateFees($data);
  }
}
