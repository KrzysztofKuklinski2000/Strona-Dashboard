<?php 
namespace App\Service\Email;

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

class EmailService {
  private Mailer $mailer;
  private array $config;

  public function __construct()
  {
    $this->config = require dirname(__DIR__, 3) . '/config/mail.php';

    $dsn = sprintf(
      'smtp://%s:%s@%s:%d',
      $this->config['username'],
      $this->config['password'],
      $this->config['host'], 
      $this->config['port']
    );

    $transport = Transport::fromDsn($dsn);
    $this->mailer = new Mailer($transport);

  }

  public function sendTestEmail(string $recipientEmail): void
  {
    $email = (new Email())
      ->from($this->config['from_email'])
      ->to($recipientEmail)               
      ->subject('Test połączenia z Mailtrap!')
      ->text('Połączono!');

    $this->mailer->send($email);
  }
}