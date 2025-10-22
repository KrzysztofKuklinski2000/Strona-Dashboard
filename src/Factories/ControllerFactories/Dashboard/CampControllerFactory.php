<?php

declare(strict_types=1);

namespace App\Factories\ControllerFactories\Dashboard;

use App\View;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Core\ActionResolver;
use App\Controller\AbstractController;
use App\Controller\Dashboard\CampController;
use App\Factories\ServiceFactories\DashboardServiceFactory;
use App\Factories\ControllerFactories\ControllerFactoryInterface;

class CampControllerFactory implements ControllerFactoryInterface
{
  private DashboardServiceFactory $serviceFactory;

  public function __construct(private array $dbconfig)
  {
    $this->serviceFactory = new DashboardServiceFactory($dbconfig);
  }

  public function createController(Request $request, EasyCSRF $easyCSRF): AbstractController
  {
    $dashboardService = $this->serviceFactory->createService();

    $view = new View();
    $actionResolver = new ActionResolver();

    return new CampController(
      $dashboardService,
      $request,
      $easyCSRF,
      $view,
      $actionResolver,
    );
  }
}
