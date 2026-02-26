<?php

namespace App\Factories\ServiceFactories\Dashboard;

use App\Factories\ServiceFactories\EmailServiceFactory;
use App\Factories\ServiceFactories\ServiceFactoryInterface;
use App\Notification\NotificationService;
use App\Repository\DashboardRepository;
use App\Repository\SubscriberRepository;
use App\Service\Dashboard\TimetableService;
use PDO;

class TimetableServiceFactory implements ServiceFactoryInterface
{
  public function __construct(private PDO $pdo) {}

  public function createService(): TimetableService
  {
    $subscriberRepository = new SubscriberRepository($this->pdo);
    $emailService = (new EmailServiceFactory())->createService();
    
    $repository = new DashboardRepository($this->pdo);
    $notificationService = new NotificationService($emailService, $subscriberRepository
    );

    return new TimetableService($repository, $notificationService);
  }
}