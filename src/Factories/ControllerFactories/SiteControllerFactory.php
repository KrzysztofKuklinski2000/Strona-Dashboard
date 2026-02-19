<?php 
declare(strict_types=1);

namespace App\Factories\ControllerFactories;


use PDO;
use App\View;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Controller\SiteController;
use App\Controller\AbstractController;
use App\Factories\ServiceFactories\SiteServiceFactory;

class SiteControllerFactory implements ControllerFactoryInterface {
  private SiteServiceFactory $serviceFactory;

  public function __construct(PDO $pdo){
    $this->serviceFactory = new SiteServiceFactory($pdo);
  }
  
  public function createController(Request $request, EasyCSRF $easyCSRF): AbstractController {
    $siteService = $this->serviceFactory->createService();

    $view = new View();
    

    return new SiteController(
      $request,
      $siteService, 
      $easyCSRF,
      $view,
    );
  }
}