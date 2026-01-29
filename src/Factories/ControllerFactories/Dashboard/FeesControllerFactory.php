<?php

declare(strict_types=1);

namespace App\Factories\ControllerFactories\Dashboard;

use PDO;
use App\View;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Core\ActionResolver;
use App\Middleware\CsrfMiddleware;
use App\Controller\AbstractController;
use App\Controller\Dashboard\FeesController;
use App\Factories\ServiceFactories\DashboardServiceFactory;
use App\Factories\ControllerFactories\ControllerFactoryInterface;

class FeesControllerFactory implements ControllerFactoryInterface
{
  private DashboardServiceFactory $serviceFactory;

  public function __construct(PDO $pdo)
  {
    $this->serviceFactory = new DashboardServiceFactory($pdo);
  }

  public function createController(Request $request, EasyCSRF $easyCSRF): AbstractController
  {
    $dashboardService = $this->serviceFactory->createService();

    $view = new View();
    $actionResolver = new ActionResolver();
    $csrfMiddleware = new CsrfMiddleware($easyCSRF, $request);



    return new FeesController(
      $dashboardService,
      $request,
      $easyCSRF,
      $view,
      $actionResolver,
      $csrfMiddleware
    );
  }
}
