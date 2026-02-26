<?php

declare(strict_types=1);

namespace App\Factories\ControllerFactories\Dashboard;


use App\Controller\AbstractController;
use App\Controller\Dashboard\TimetableController;
use App\Core\Request;
use App\Factories\ControllerFactories\ControllerFactoryInterface;
use App\Factories\ServiceFactories\Dashboard\TimetableServiceFactory;
use App\Middleware\CsrfMiddleware;
use App\View;
use EasyCSRF\EasyCSRF;
use PDO;

class TimetableControllerFactory implements ControllerFactoryInterface
{
  private TimetableServiceFactory $serviceFactory;


  public function __construct(PDO $pdo)
  {
    $this->serviceFactory = new TimetableServiceFactory($pdo);
  }

  public function createController(Request $request, EasyCSRF $easyCSRF): AbstractController
  {
    $timetableService = $this->serviceFactory->createService();

    $view = new View();
    $csrfMiddleware = new CsrfMiddleware($easyCSRF, $request);

    return new TimetableController(
      $timetableService,
      $request,
      $easyCSRF,
      $view,
      $csrfMiddleware
    );
  }
}
