<?php 
namespace App\Notification\Email;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Mailer {

  public function __construct(
    private MailerInterface $mailer, 
    private array $config
    ) {
  }

  public function send(string $to, string $subject, string $htmlContent): void
  {
      $email = (new Email())
        ->from($this->config['from_email'])
        ->to($to)
        ->subject($subject)
        ->html($htmlContent);

      $this->mailer->send($email);
  }
}