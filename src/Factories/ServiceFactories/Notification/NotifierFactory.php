<?php

namespace App\Factories\ServiceFactories\Notification;

use App\Core\Config;
use App\Factories\ServiceFactories\ServiceFactoryInterface;
use App\Notification\Notifier;
use App\Repository\Dashboard\SubscriberRepository;
use PDO;

readonly class NotifierFactory implements ServiceFactoryInterface
{
    public function __construct(private PDO $pdo, private Config $config)
    {
    }

    public function createService(): Notifier
    {
        $subscriberRepository = new SubscriberRepository($this->pdo);
        $mailer = (new MailerFactory($this->config))->createService();

        return new Notifier($mailer, $subscriberRepository, $this->config->getUrl(), $this->config->getTemplatesPath());
    }
}