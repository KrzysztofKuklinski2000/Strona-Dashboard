<?php

declare(strict_types=1);

namespace App\Notification\Observer;

use App\DTO\Notification\NotificationReportDto;
use App\Notification\Notifier;

class EmailNotificationObserver implements TimetableObserverInterface
{
    public function __construct(private Notifier $notification)
    {
    }

    public function update(string $customMessage = ''): NotificationReportDto
    {
        return $this->notification->notifyAboutTimetableUpdate($customMessage);
    }
}
