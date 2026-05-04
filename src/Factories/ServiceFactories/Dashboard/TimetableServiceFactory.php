<?php

namespace App\Factories\ServiceFactories\Dashboard;

use App\Core\Config;
use App\Factories\ServiceFactories\Notification\NotifierFactory;
use App\Factories\ServiceFactories\ServiceFactoryInterface;
use App\Notification\Observer\EmailNotificationObserver;
use App\Repository\Dashboard\TimetableRepository;
use App\Service\Dashboard\TimetableService;
use PDO;

readonly class TimetableServiceFactory implements ServiceFactoryInterface
{
  public function __construct(private PDO $pdo, private Config $config) {}

  public function createService(): TimetableService
  {
    $timetableRepository = new TimetableRepository($this->pdo);
    $timetableService = new TimetableService($timetableRepository);

    $notifier = (new NotifierFactory($this->pdo, $this->config))->createService();
    $emailObserver = new EmailNotificationObserver($notifier);
    $timetableService->attach($emailObserver);


    return $timetableService;
  }
}