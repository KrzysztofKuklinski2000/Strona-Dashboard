<?php

namespace App\Factories\ServiceFactories\Notification;

use App\Factories\ServiceFactories\ServiceFactoryInterface;
use App\Notification\Notifier;
use App\Repository\SubscriberRepository;
use PDO;

class NotifierFactory implements ServiceFactoryInterface {
  public function __construct(private PDO $pdo) {}

  public function createService() {
    $subscriberRepository = new SubscriberRepository($this->pdo);
    $mailer = (new MailerFactory())->createService();

    return new Notifier($mailer, $subscriberRepository);
  }
}