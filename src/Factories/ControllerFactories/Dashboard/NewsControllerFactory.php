<?php

declare(strict_types=1);

namespace App\Factories\ControllerFactories\Dashboard;


use App\Controller\AbstractController;
use App\Controller\Dashboard\NewsController;
use App\Core\Request;
use App\Factories\ControllerFactories\ControllerFactoryInterface;
use App\Factories\ServiceFactories\Dashboard\NewsServiceFactory;
use App\Middleware\CsrfMiddleware;
use App\View;
use EasyCSRF\EasyCSRF;
use PDO;

class NewsControllerFactory implements ControllerFactoryInterface
{
  private NewsServiceFactory $serviceFactory;

  public function __construct(PDO $pdo)
  {
    $this->serviceFactory = new NewsServiceFactory($pdo);
  }

  public function createController(Request $request, EasyCSRF $easyCSRF): AbstractController
  {
    $service = $this->serviceFactory->createService();

    $view = new View();
    $csrfMiddleware = new CsrfMiddleware($easyCSRF, $request);

    return new NewsController(
      $service,
      $request,
      $easyCSRF,
      $view,
      $csrfMiddleware
    );
  }
}
