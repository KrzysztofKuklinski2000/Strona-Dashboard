<?php
namespace App\Factories\ServiceFactories;

use App\Repository\Dashboard\TimetableRepository;
use PDO;
use App\Service\SiteService;
use App\Repository\SiteRepository;

class SiteServiceFactory implements ServiceFactoryInterface
{
  public function __construct(private PDO $pdo) {}

  public function createService(){
    $repository = new SiteRepository($this->pdo);
    $timetableRepository = new TimetableRepository($this->pdo);
    return new SiteService($repository, $timetableRepository);
  }
}
