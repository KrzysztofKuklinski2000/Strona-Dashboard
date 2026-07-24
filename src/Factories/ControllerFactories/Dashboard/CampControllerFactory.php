<?php

declare(strict_types=1);

namespace App\Factories\ControllerFactories\Dashboard;

use App\Controller\AbstractController;
use App\Controller\Dashboard\CampController;
use App\Core\ContextController;
use App\Factories\ControllerFactories\ControllerFactoryInterface;
use App\Factories\ServiceFactories\Dashboard\CampServiceFactory;
use App\Mapper\Dashboard\CampRequestMapper;
use PDO;

class CampControllerFactory implements ControllerFactoryInterface
{
  private CampServiceFactory $serviceFactory;

  public function __construct(PDO $pdo)
  {
    $this->serviceFactory = new CampServiceFactory($pdo);
  }

  public function createController(ContextController $contextController): AbstractController
  {
    $service = $this->serviceFactory->createService();

    $campRequestMapper = new CampRequestMapper(
        $contextController->request,
        $contextController->validator,
    );

    return new CampController(
      $service,
      $campRequestMapper,
      $contextController
    );
  }
}
