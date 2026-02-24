<?php

declare(strict_types=1);

namespace App\Factories\ControllerFactories\Dashboard;


use App\Controller\AbstractController;
use App\Controller\Dashboard\TimetableController;
use App\Core\Request;
use App\Factories\ControllerFactories\ControllerFactoryInterface;
use App\Factories\ServiceFactories\DashboardServiceFactory;
use App\Factories\ServiceFactories\EmailServiceFactory;
use App\Middleware\CsrfMiddleware;
use App\View;
use EasyCSRF\EasyCSRF;
use PDO;

class TimetableControllerFactory implements ControllerFactoryInterface
{
  private DashboardServiceFactory $serviceFactory;
  private EmailServiceFactory $emailServiceFactory;


  public function __construct(PDO $pdo)
  {
    $this->serviceFactory = new DashboardServiceFactory($pdo);
    $this->emailServiceFactory = new EmailServiceFactory();
  }

  public function createController(Request $request, EasyCSRF $easyCSRF): AbstractController
  {
    $dashboardService = $this->serviceFactory->createService();
    $emailService = $this->emailServiceFactory->createService();

    $view = new View();
    $csrfMiddleware = new CsrfMiddleware($easyCSRF, $request);

    return new TimetableController(
      $dashboardService,
      $emailService,
      $request,
      $easyCSRF,
      $view,
      $csrfMiddleware
    );
  }
}
