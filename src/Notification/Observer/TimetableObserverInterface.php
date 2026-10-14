<?php

declare(strict_types=1);

namespace App\Notification\Observer;

use App\DTO\Notification\NotificationReportDto;

interface TimetableObserverInterface
{
    public function update(string $customMessage = ''): NotificationReportDto;
}
