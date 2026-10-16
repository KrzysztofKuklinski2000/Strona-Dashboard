<?php

declare(strict_types=1);

namespace App\Factories\ServiceFactories\Notification;

use App\Core\Config;
use App\Factories\ServiceFactories\ServiceFactoryInterface;
use App\Notification\Email\Mailer;
use RuntimeException;
use Symfony\Component\Mailer\Mailer as SymfonyMailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;

readonly class MailerFactory implements ServiceFactoryInterface
{
    public function __construct(private Config $config)
    {
    }

    public function createService(): Mailer
    {
        $mailConfig = $this->config->getMailConfig();

        $dsn = $mailConfig['dsn'] ?? '';
        $fromEmail = $mailConfig['from_email'] ?? '';

        if($dsn === '') {
            throw new RuntimeException('Brak konfiguracji MAILER_DSN.');
        }

        if($fromEmail === '') {
            throw new RuntimeException(
                'Brak konfiguracji MAIL_FROM_EMAIL.',
            );
        }

        $transport = Transport::fromDsn($dsn);

        if($this->config->getEnv() !== 'dev') {
            if(!($transport instanceof EsmtpTransport)) {
                throw new RuntimeException(
                    'Poza środowiskiem dev wymagany jest transport SMTP.',
                );
            }

            $transport->setAutoTls(true);
            $transport->setRequireTls(true);
        }

        return new Mailer(new SymfonyMailer($transport), $mailConfig);
    }
}
