<?php
namespace App\Factories\ServiceFactories;

use App\Service\SiteService;
use App\Repository\SiteRepository;

class SiteServiceFactory implements ServiceFactoryInterface
{
  public function __construct(private array $dbconfig) {}

  public function createService(){
    $repository = new SiteRepository($this->dbconfig);
    return new SiteService($repository);
  }
}
