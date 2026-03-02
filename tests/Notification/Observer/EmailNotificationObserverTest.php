<?php

use App\Notification\Notifier;
use App\Notification\Observer\EmailNotificationObserver;
use PHPUnit\Framework\TestCase;

class EmailNotificationObserverTest extends TestCase
{
    public function testShouldCallsNotifyAboutTimetableUpdate(): void {
      //GIVEN
      $notifierMock = $this->createMock(Notifier::class);
      $emailNotificationObserver = new EmailNotificationObserver($notifierMock);


      //EXPECTS 
      $notifierMock->expects($this->once())
        ->method('notifyAboutTimetableUpdate');


      //WHEN
      $emailNotificationObserver->update();
    }
}