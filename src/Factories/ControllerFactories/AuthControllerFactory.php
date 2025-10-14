<?php 
declare(strict_types=1);

namespace App\Factories\ControllerFactories;

use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Controller\AuthController;
use App\Controller\AbstractController;
use App\Factories\ServiceFactories\AuthServiceFactory;
use App\Factories\ControllerFactories\ControllerFactoryInterface;

class AuthControllerFactory implements ControllerFactoryInterface {
  private AuthServiceFactory $serviceFactory;


  public function __construct(private array $dbconfig){
    $this->serviceFactory = new AuthServiceFactory($dbconfig);
  }

  public function createController(Request $request, EasyCSRF $easyCSRF): AbstractController {
    $authService = $this->serviceFactory->createService();
    return new AuthController(
      $request,
      $authService, 
      $easyCSRF);
  }
}