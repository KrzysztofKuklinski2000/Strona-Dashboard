<?php 
declare(strict_types=1);

namespace App\Factories\ControllerFactories;

use App\View;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Core\ActionResolver;
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

    $view = new View();
    $actionResolver = new ActionResolver();

    return new AuthController(
      $request,
      $authService, 
      $easyCSRF,
      $view,
      $actionResolver
    );
  }
}