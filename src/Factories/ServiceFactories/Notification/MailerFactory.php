<?php

namespace App\Factories\ServiceFactories\Notification;

use App\Core\Config;
use App\Factories\ServiceFactories\ServiceFactoryInterface;
use App\Notification\Email\Mailer;
use Symfony\Component\Mailer\Mailer as SymfonyMailer;
use Symfony\Component\Mailer\Transport;

readonly class MailerFactory implements ServiceFactoryInterface
{
    public function __construct(private Config $config)
    {
    }

    public function createService(): Mailer
    {
        $mailConfig = $this->config->getMailConfig();

        $dsn = sprintf('smtp://%s:%d', $mailConfig['host'], $mailConfig['port']);

        $transport = Transport::fromDsn($dsn);

        return new Mailer(new SymfonyMailer($transport), $mailConfig);
    }
}