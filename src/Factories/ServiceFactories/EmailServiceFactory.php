<?php 

namespace App\Factories\ServiceFactories;

use App\Notification\Email\EmailService;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;

class EmailServiceFactory {
  public function createService(){
    $config = require dirname(__DIR__, 3) . '/config/mail.php';

    $dsn = sprintf(
      'smtp://%s:%s@%s:%d',
      $config['username'],
      $config['password'],
      $config['host'],
      $config['port']
    );

    $transport = Transport::fromDsn($dsn);

    return new EmailService(new Mailer($transport), $config);
  }
}