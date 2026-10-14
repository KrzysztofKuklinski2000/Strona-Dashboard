<?php

declare(strict_types=1);

namespace App\Traits;

use App\DTO\Notification\NotificationReportDto;
use App\Notification\Observer\TimetableObserverInterface;

trait Observable
{
    private TimetableObserverInterface $observer;

    public function attach(TimetableObserverInterface $observer): void
    {
        $this->observer = $observer;
    }

    private function notify(string $customMessage): NotificationReportDto
    {
        return $this->observer->update($customMessage);
    }
}
