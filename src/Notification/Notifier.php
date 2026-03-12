<?php

namespace App\Notification;

use App\Notification\Email\Mailer;
use App\Repository\SubscriberRepository;


class Notifier {
  public function __construct(
    private Mailer $mailer,
    private SubscriberRepository $subscriberRepository
  ) {}

  public function notifyAboutTimetableUpdate(): void
  {
    $subscribers = $this->subscriberRepository->getActiveEmails();

    if(empty($subscribers)) {
      return;
    }

    foreach ($subscribers as $subscriber) {
      $email = $subscriber['email'];
      $token = $subscriber['token'];

      $unsubscribeUrl = "http://localhost:8000/unsubscribe?token=" . $token;

      ob_start();
      require dirname(__DIR__, 2) . '/templates/emails/timetable_updated.php';
      $htmlContent = ob_get_clean();
      $htmlContent .= "<br><br><hr><p style='font-size: 12px;'>Chcesz zrezygnować? <a href='$unsubscribeUrl'>Wypisz się tutaj</a></p>";


      $this->mailer->send($email, 'Aktualizacja grafiku', $htmlContent);
    }
  }

  public function sendConfirmationEmail(string $email, string $token): void {
    $subject = "Potwierdź zapis do newslettera - Karate Kyokushin";
    
    $confirmUrl = "http://localhost:8000/confirm-subscription?token=" . $token;

    $message = "Oss!\n\n";
    $message .= "Dziękujemy za chęć zapisu do powiadomień o aktualizacjach grafiku klubu Karate Kyokushin.\n";
    $message .= "Aby potwierdzić swój adres e-mail i aktywować subskrypcję, kliknij w poniższy link:\n\n";
    $message .= "<a href=".$confirmUrl." >link</a>" . "\n\n";
    $message .= "Jeśli to nie Ty zapisywałeś się na naszej stronie, zignoruj tę wiadomość.\n";
    $message .= "Pozdrawiamy,\nKlub Karate Kyokushin";

    $this->mailer->send($email, $subject, $message);
  }
}