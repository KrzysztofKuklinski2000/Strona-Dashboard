<?php

declare(strict_types=1);

namespace App\Notification;

use App\Exception\RepositoryException;
use App\Notification\Email\Mailer;
use App\Repository\Dashboard\SubscriberRepository;

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
     * Wysyła osobny mail do każdego aktywnego odbiorcy z jego linkiem wypisania.
     * Obecna wysyłka jest synchroniczna; wyjątek przy jednym mailu przerywa pętlę.
     *
     * @throws RepositoryException
     */
    public function notifyAboutTimetableUpdate(string $customMessage): void
    {
        $subscribers = $this->subscriberRepository->getActiveEmails();

        if (empty($subscribers)) {
            return;
        }

        $baseUrl = rtrim($this->appUrl, '/');

        foreach ($subscribers as $subscriber) {
            $email = $subscriber->email;
            // Jawny token jest potrzebny do budowania linku w każdym kolejnym powiadomieniu.
            // Nie jest to token potwierdzenia. Podpisane linki są zapisane jako osobne zadanie w TODO.md.
            $token = $subscriber->unsubscribeToken;

            $unsubscribeUrl = "$baseUrl/unsubscribe?token=$token";

            ob_start();
            require "$this->templatePath/emails/timetable_updated.php";
            $htmlContent = ob_get_clean();

            $this->mailer->send($email, 'Aktualizacja grafiku', $htmlContent);
        }
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
