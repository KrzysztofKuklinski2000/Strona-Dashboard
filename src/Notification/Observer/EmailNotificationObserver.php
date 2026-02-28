<?php

namespace App\Notification\Observer;

use App\Notification\Notifier;

class EmailNotificationObserver implements TimetableObserverInterface {

  public function __construct(private Notifier $notification){}

  public function update(): void {
    $this->notification->notifyAboutTimetableUpdate();
  }
}