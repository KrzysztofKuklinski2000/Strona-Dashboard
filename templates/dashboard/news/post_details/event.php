<?php
$payload = isset($payload) && is_array($payload)
    ? $payload
    : (json_decode((string) ($data->payload ?? ''), true) ?: []);

$eventDate = is_scalar($payload['event_date'] ?? null)
    ? (string) $payload['event_date']
    : '';
$eventTimestamp = $eventDate !== '' ? strtotime($eventDate) : false;
$eventDateLabel = $eventTimestamp ? date('d.m.Y', $eventTimestamp) : 'Nie podano';
$startTime = is_scalar($payload['start_time'] ?? null)
    ? substr((string) $payload['start_time'], 0, 5)
    : '';
$endTime = is_scalar($payload['end_time'] ?? null)
    ? substr((string) $payload['end_time'], 0, 5)
    : '';
$location = is_scalar($payload['location'] ?? null)
    ? (string) $payload['location']
    : '';
$link = is_array($payload['link'] ?? null) ? $payload['link'] : [];
?>

<div class="homepage-post-details__image-list news-event-details">
    <div class="news-event-details__date">
        <i class="fa-regular fa-calendar-days" aria-hidden="true"></i>
        <span>Termin</span>
        <?php if ($eventDate !== ''): ?>
            <time datetime="<?= e($eventDate) ?>"><?= e($eventDateLabel) ?></time>
        <?php else: ?>
            <strong><?= e($eventDateLabel) ?></strong>
        <?php endif ?>
    </div>

    <div>
        <p class="homepage-post-details__eyebrow">Wydarzenie</p>
        <h4><?= e($data->title ?? '') ?></h4>

        <?php if (!empty($payload['description'])): ?>
            <p class="homepage-post-details__description"><?= e_br($payload['description']) ?></p>
        <?php endif ?>

        <div class="homepage-post-details__cards news-event-details__meta">
            <div class="homepage-post-details__card">
                <i class="fa-regular fa-clock" aria-hidden="true"></i>
                <strong>Godzina</strong>
                <p>
                    <?php if ($startTime !== ''): ?>
                        <?= e($startTime) ?><?= $endTime !== '' ? ' – ' . e($endTime) : '' ?>
                    <?php else: ?>
                        Nie podano
                    <?php endif ?>
                </p>
            </div>

            <div class="homepage-post-details__card">
                <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                <strong>Miejsce</strong>
                <p><?= e($location !== '' ? $location : 'Nie podano') ?></p>
            </div>
        </div>

        <?php if (!empty($link['label']) && !empty($link['url'])): ?>
            <p class="homepage-post-details__link">
                <i class="fa-solid fa-link" aria-hidden="true"></i>
                <?= e($link['label']) ?> — <?= e($link['url']) ?>
            </p>
        <?php endif ?>
    </div>
</div>
