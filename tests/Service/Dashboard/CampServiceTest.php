<?php

namespace Tests\Service\Dashboard;

use App\Repository\DashboardRepository;
use App\Service\Dashboard\CampService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CampServiceTest extends TestCase {

  private DashboardRepository | MockObject $repository;
  private CampService $service;

  protected function setUp(): void
  {
    $this->repository = $this->createMock(DashboardRepository::class);
    $this->service = new CampService($this->repository);
  }

  public function testShouldGetCampAndReturnFirstElement(): void
  {
    $camp = [['city' => 'warszawa']];
    $this->repository->expects($this->once())->method('getDashboardData')->with('camp')->willReturn($camp);
    $this->assertEquals(['city' => 'warszawa'], $this->service->getCamp());
  }

  public function testShouldUpdateCamp(): void
  {
    $data = ['city' => 'warszawa'];
    $this->repository->expects($this->once())->method('edit')->with('camp', $data);
    $this->service->updateCamp($data);
  }
}