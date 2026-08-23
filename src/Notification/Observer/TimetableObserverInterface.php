<?php

declare(strict_types=1);

namespace App\Notification\Observer;

interface TimetableObserverInterface
{
    public function update(string $customMessage = ''): void;
}
