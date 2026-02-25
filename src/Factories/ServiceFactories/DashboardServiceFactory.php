<?php

namespace App\Factories\ServiceFactories;

use App\Core\FileHandler;
use App\Repository\DashboardRepository;
use App\Repository\SubscriberRepository;
use App\Service\Dashboard\DashboardService;
use App\Service\NotificationService;
use PDO;

class DashboardServiceFactory implements ServiceFactoryInterface {

  public function __construct(private PDO $pdo){}

  public function createService() {
    $subscriberRepository = new SubscriberRepository($this->pdo);
    $emailService = (new EmailServiceFactory())->createService();
    
    $repository = new DashboardRepository($this->pdo);
    $fileHandler = new FileHandler();
    $notificationService = new NotificationService($emailService, $subscriberRepository);

    return new DashboardService(
      $repository, 
      $fileHandler,
      $notificationService,
      );
  }
}