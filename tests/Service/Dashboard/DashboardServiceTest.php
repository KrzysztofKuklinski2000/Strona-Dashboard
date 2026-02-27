<?php

namespace Tests\Service\Dashboard;

use App\Notification\NotificationService;
use App\Repository\DashboardRepository;
use App\Service\Dashboard\DashboardService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DashboardServiceTest extends TestCase
{
  private DashboardRepository | MockObject $repository;
  private DashboardService  $service;
  private NotificationService | MockObject $notificationService;


  public function setUp(): void
  {
    $this->repository = $this->createMock(DashboardRepository::class);
    $this->notificationService = $this->createMock(NotificationService::class);


    $this->service = new DashboardService(
      $this->repository, 
      $this->notificationService,
    );
  }

  

}
