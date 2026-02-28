<?php

namespace App\Notification\Observer;

use App\Notification\NotificationService;

class EmailNotificationObserver implements TimetableObserverInterface {

  public function __construct(private NotificationService $notification){}

  public function update(): void {
    $this->notification->notifyAboutTimetableUpdate();
  }
}