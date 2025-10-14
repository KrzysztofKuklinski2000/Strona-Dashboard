<?php 
declare(strict_types=1);

namespace App\Factories\ControllerFactories;


use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Controller\SiteController;
use App\Controller\AbstractController;
use App\Factories\ServiceFactories\SiteServiceFactory;

class SiteControllerFactory implements ControllerFactoryInterface {
  private SiteServiceFactory $serviceFactory;

  public function __construct(private array $dbconfig){
    $this->serviceFactory = new SiteServiceFactory($dbconfig);
  }
  
  public function createController(Request $request, EasyCSRF $easyCSRF): AbstractController {
    $siteService = $this->serviceFactory->createService();
    return new SiteController(
      $request,
      $siteService, 
      $easyCSRF);
  }
}