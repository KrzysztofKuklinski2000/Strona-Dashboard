<?php
namespace App\Factories\ServiceFactories;

use PDO;
use App\Service\SiteService;
use App\Repository\SiteRepository;

class SiteServiceFactory implements ServiceFactoryInterface
{
  public function __construct(private PDO $pdo) {}

  public function createService(){
    $repository = new SiteRepository($this->pdo);
    return new SiteService($repository);
  }
}
