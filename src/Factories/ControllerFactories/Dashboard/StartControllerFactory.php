<?php

declare(strict_types=1);

namespace App\Factories\ControllerFactories\Dashboard;

use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Controller\AbstractController;
use App\Controller\Dashboard\StartController;
use App\Factories\ServiceFactories\DashboardServiceFactory;
use App\Factories\ControllerFactories\ControllerFactoryInterface;

class StartControllerFactory implements ControllerFactoryInterface
{
  private DashboardServiceFactory $serviceFactory;

  public function __construct(private array $dbconfig)
  {
    $this->serviceFactory = new DashboardServiceFactory($dbconfig);
  }

  public function createController(Request $request, EasyCSRF $easyCSRF): AbstractController
  {
    $dashboardService = $this->serviceFactory->createService();

    return new StartController(
      $dashboardService,
      $request,
      $easyCSRF
    );
  }
}
