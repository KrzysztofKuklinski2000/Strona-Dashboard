<?php

namespace App\Factories\ServiceFactories\Dashboard;

use App\Factories\ServiceFactories\EmailServiceFactory;
use App\Factories\ServiceFactories\ServiceFactoryInterface;
use App\Notification\NotificationService;
use App\Notification\Observer\EmailNotificationObserver;
use App\Repository\DashboardRepository;
use App\Repository\SubscriberRepository;
use App\Service\Dashboard\TimetableService;
use PDO;

class TimetableServiceFactory implements ServiceFactoryInterface
{
  public function __construct(private PDO $pdo) {}

  public function createService(): TimetableService
  {
    $repository = new DashboardRepository($this->pdo);
    $timetableService = new TimetableService($repository);

    $subscriberRepository = new SubscriberRepository($this->pdo);
    $emailService = (new EmailServiceFactory())->createService();
    $notificationService = new NotificationService($emailService, $subscriberRepository);

    $emailObserver = new EmailNotificationObserver($notificationService);
    $timetableService->attach($emailObserver);


    return $timetableService;
  }
}