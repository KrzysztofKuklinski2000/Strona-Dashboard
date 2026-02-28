<?php 

namespace App\Factories\ServiceFactories\Notification;

use App\Factories\ServiceFactories\ServiceFactoryInterface;
use App\Notification\Email\Mailer;
use Symfony\Component\Mailer\Mailer as SymfonyMailer;
use Symfony\Component\Mailer\Transport;

class MailerFactory implements ServiceFactoryInterface{
  public function createService(){
    $config = require dirname(__DIR__, 4) . '/config/mail.php';

    $dsn = sprintf(
      'smtp://%s:%s@%s:%d',
      $config['username'],
      $config['password'],
      $config['host'],
      $config['port']
    );

    $transport = Transport::fromDsn($dsn);

    return new Mailer(new SymfonyMailer($transport), $config);
  }
}