<?php 
namespace App\Service\Email;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailService {

  public function __construct(
    private MailerInterface $mailer, 
    private array $config
    ) {
  }

  public function sendTimetableUpdate(array $users, string $htmlContent): void
  {
    $email = (new Email())
      ->from($this->config['from_email'])
      ->subject('Aktualizacja grafiku')
      ->html($htmlContent);

      foreach($users as $user) {
        $email->addBcc($user);
      }
      
    $this->mailer->send($email);
  }
}