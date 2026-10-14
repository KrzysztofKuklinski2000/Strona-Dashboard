<?php
if (!is_array($notificationReport ?? null)) {
    return;
}

$sentCount = (int) $notificationReport['sent_count'];
$failedRecipients = $notificationReport['failed_recipients'];
$failedCount = count($failedRecipients);
$recipientsLoaded = $notificationReport['recipients_loaded'] ?? true;
$reportState = !$recipientsLoaded || $failedCount > 0 ? 'warning' : ($sentCount > 0 ? 'success' : 'info');
$reportMessage = !$recipientsLoaded
    ? 'Zmiana grafiku została zapisana, ale nie udało się pobrać odbiorców. Powiadomienia nie zostały wysłane.'
    : match ($reportState) {
    'warning' => 'Zmiana grafiku została zapisana, ale nie wszystkie powiadomienia udało się wysłać.',
    'success' => 'Zmiana grafiku została zapisana. Wszystkie powiadomienia zostały przyjęte do wysyłki.',
    default => 'Zmiana grafiku została zapisana. Nie ma aktywnych subskrybentów, do których można wysłać powiadomienie.',
};
$reportIcon = match ($reportState) {
    'warning' => 'fa-solid fa-triangle-exclamation',
    'success' => 'fa-solid fa-check',
    default => 'fa-solid fa-info',
};
$failureReasons = [
    'transport_error' => 'Błąd połączenia lub wysyłki przez serwer pocztowy.',
    'invalid_address' => 'Nieprawidłowy format adresu e-mail w wiadomości.',
    'missing_unsubscribe_token' => 'Brak tokenu potrzebnego do utworzenia linku wypisania.',
];
?>
<section
    class="notification-report notification-report--<?= e($reportState) ?>"
    aria-labelledby="notification-report-title"
>
    <div class="notification-report__heading">
        <span class="notification-report__icon" aria-hidden="true">
            <i class="<?= e($reportIcon) ?>"></i>
        </span>
        <div class="notification-report__intro">
            <h2 id="notification-report-title">Raport powiadomień</h2>
            <p><?= e($reportMessage) ?></p>
        </div>
    </div>

    <?php if ($recipientsLoaded): ?>
        <dl class="notification-report__counts">
            <div>
                <dt>Przyjęte do wysyłki</dt>
                <dd><?= e((string) $sentCount) ?></dd>
            </div>
            <div>
                <dt>Nieudane wysyłki</dt>
                <dd><?= e((string) $failedCount) ?></dd>
            </div>
        </dl>
    <?php else: ?>
        <p class="notification-report__help">
            Nie trzeba ponownie zapisywać zmiany grafiku. Sprawdź logi aplikacji; wysyłka nie zostanie ponowiona automatycznie.
        </p>
    <?php endif; ?>

    <?php if ($recipientsLoaded && $failedCount > 0): ?>
        <details class="notification-report__details">
            <summary>
                <span>Adresy z nieudaną wysyłką (<?= e((string) $failedCount) ?>)</span>
                <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
            </summary>
            <ul class="notification-report__recipients">
                <?php foreach ($failedRecipients as $recipient): ?>
                    <li>
                        <strong><?= e($recipient['email']) ?></strong>
                        <span><?= e($failureReasons[$recipient['reason']] ?? 'Nie udało się wysłać powiadomienia.') ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </details>
    <?php endif; ?>

</section>
