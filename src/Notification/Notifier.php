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
    $emails = $this->subscriberRepository->getAllEmails();

    if(empty($emails)) {
      return;
    }

    ob_start();
    require dirname(__DIR__, 2) . '/templates/emails/timetable_updated.php';
    $htmlContent = ob_get_clean();

    foreach ($emails as $email) {
      $this->mailer->send($email, 'Aktualizacja grafiku', $htmlContent);
    }
  }
}