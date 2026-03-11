<?php 
declare(strict_types=1);

namespace App\Factories\ControllerFactories;


use App\Controller\AbstractController;
use App\Controller\SiteController;
use App\Core\Request;
use App\Factories\ServiceFactories\SiteServiceFactory;
use App\Middleware\CsrfMiddleware;
use App\View;
use EasyCSRF\EasyCSRF;
use PDO;

class SiteControllerFactory implements ControllerFactoryInterface {
  private SiteServiceFactory $serviceFactory;

  public function __construct(PDO $pdo){
    $this->serviceFactory = new SiteServiceFactory($pdo);
  }
  
  public function createController(Request $request, EasyCSRF $easyCSRF): AbstractController {
    $siteService = $this->serviceFactory->createService();
    $csrfMiddleware = new CsrfMiddleware($easyCSRF, $request);

    $view = new View();
    

    return new SiteController(
      $request,
      $siteService, 
      $view,
      $csrfMiddleware
    );
  }
}