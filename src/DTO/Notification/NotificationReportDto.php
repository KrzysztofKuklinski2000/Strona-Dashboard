<?php
declare(strict_types=1);

namespace App\DTO\Notification;


/**
 * Wynik jednej wysyłki powiadomień.
 * sentCount oznacza liczbe wysłanych poprawinie wiadomości.
 */
readonly class NotificationReportDto
{
    /**
     * @param list<array{id: int, email: string, reason: string}> $failedRecipients
     */
    public function __construct(
        public int   $sentCount,
        public array $failedRecipients,
        public bool $recipientsLoaded = true,
    )
    {
    }


    public function getFailedRecipientsCount(): int
    {
        return count($this->failedRecipients);
    }
}