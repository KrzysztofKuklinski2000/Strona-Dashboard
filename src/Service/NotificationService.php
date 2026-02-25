<?php

namespace App\Service;

use App\Repository\SubscriberRepository;
use App\Service\Email\EmailService;


class NotificationService {
  public function __construct(
    private EmailService $emailService,
    private SubscriberRepository $subscriberRepository
  ) {}

  public function notifyAboutTimetableUpdate(string $htmlContent): void
  {
    $emails = $this->subscriberRepository->getAllEmails();

    if(empty($emails)) {
      return;
    }

    $this->emailService->sendTimetableUpdate($emails, $htmlContent);
  }
}