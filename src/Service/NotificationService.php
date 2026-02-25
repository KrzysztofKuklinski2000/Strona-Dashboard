<?php

namespace App\Service;

use App\Repository\SubscriberRepository;
use App\Service\Email\EmailService;


class NotificationService {
  public function __construct(
    private EmailService $emailService,
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

    $this->emailService->sendTimetableUpdate($emails, $htmlContent);
  }
}