<?php

declare(strict_types=1);

namespace App\Notification;

use App\DTO\Notification\NotificationReportDto;
use App\Exception\RepositoryException;
use App\Notification\Email\Mailer;
use App\Repository\Dashboard\SubscriberRepository;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Exception\RfcComplianceException;

readonly class Notifier
{
    public function __construct(
        private Mailer               $mailer,
        private SubscriberRepository $subscriberRepository,
        private string               $appUrl,
        private string               $templatePath,
    ) {
    }

    /**
     * Wysyła powiadomienia i zbiera raport.
     * Błąd transportu lub adresu jednego odbiorcy nie przerywa pozostałych wysyłek.
     */
    public function notifyAboutTimetableUpdate(string $customMessage): NotificationReportDto
    {
        try {
            $subscribers = $this->subscriberRepository->getActiveEmails();
        } catch (RepositoryException $e) {
            error_log(sprintf(
                'Timetable notification not started: reason=recipients_fetch_failed exception=%s',
                get_class($e),
            ));

            return new NotificationReportDto(
                sentCount: 0,
                failedRecipients: [],
                recipientsLoaded: false,
            );
        }

        $sentCount = 0;
        $failedRecipients = [];
        $baseUrl = rtrim($this->appUrl, '/');

        foreach ($subscribers as $subscriber) {
            $email = $subscriber->email;
            $token = $subscriber->unsubscribeToken;

            if($token === null || $token === '') {
                $failedRecipients[] = [
                    'id' => $subscriber->id,
                    'email' => $email,
                    'reason' => 'missing_unsubscribe_token',
                ];

                error_log(sprintf(
                    'Timetable notification failed: subscriber_id=%d reason=missing_unsubscribe_token',
                    $subscriber->id,
                ));

                continue;
            }

            $unsubscribeUrl = "$baseUrl/unsubscribe?token=$token";

            ob_start();
            try {
                require "$this->templatePath/emails/timetable_updated.php";
                $htmlContent = (string) ob_get_contents();
            } finally {
                ob_end_clean();
            }

            try {
                $this->mailer->send($email, 'Aktualizacja grafiku', $htmlContent);
                $sentCount++;
            } catch (TransportExceptionInterface | RfcComplianceException $e) {
                $failedRecipients[] = [
                    'id' => $subscriber->id,
                    'email' => $email,
                    'reason' => $e instanceof TransportExceptionInterface
                        ? 'transport_error'
                        : 'invalid_address',
                ];

                error_log(sprintf(
                    'Timetable notification failed: subscriber_id=%d exception=%s',
                    $subscriber->id,
                    get_class($e),
                ));
            }
        }

        $report = new NotificationReportDto($sentCount, $failedRecipients);

        error_log(sprintf(
            'Timetable notification summary: sent=%d failed=%d',
            $report->sentCount,
            $report->getFailedRecipientsCount()
        ));

        return $report;
    }

    /**
     * Wstawia do linku oryginalny losowy token; w bazie znajduje się wyłącznie jego hash.
     * Link budujemy z konfiguracji appUrl, a nie z nagłówka Host otrzymanego w żądaniu.
     */
    public function sendConfirmationEmail(string $email, string $token): void
    {
        $subject = "Potwierdź zapis do aktualności - Karate Kyokushin";
        $baseUrl = rtrim($this->appUrl, '/');
        $confirmUrl = "$baseUrl/confirm-subscription?token=$token";

        ob_start();
        require "$this->templatePath/emails/active_email.php";
        $htmlContent = ob_get_clean();

        $this->mailer->send($email, $subject, $htmlContent);
    }
}
