<?php
$eventPayload = isset($payload) && is_array($payload)
    ? $payload
    : (json_decode((string) ($content->payload ?? ''), true) ?: []);

$eventDate = is_scalar($eventPayload['event_date'] ?? null)
    ? (string) $eventPayload['event_date']
    : '';
$eventTimestamp = $eventDate !== '' ? strtotime($eventDate) : false;
$monthLabels = [
    1 => 'sty',
    2 => 'lut',
    3 => 'mar',
    4 => 'kwi',
    5 => 'maj',
    6 => 'cze',
    7 => 'lip',
    8 => 'sie',
    9 => 'wrz',
    10 => 'paź',
    11 => 'lis',
    12 => 'gru',
];
$eventDay = $eventTimestamp ? date('d', $eventTimestamp) : '--';
$eventMonth = $eventTimestamp ? $monthLabels[(int) date('n', $eventTimestamp)] : '---';
$eventYear = $eventTimestamp ? date('Y', $eventTimestamp) : '';
$eventDateLabel = $eventTimestamp ? date('d.m.Y', $eventTimestamp) : 'Termin do ustalenia';
$startTime = is_scalar($eventPayload['start_time'] ?? null)
    ? substr((string) $eventPayload['start_time'], 0, 5)
    : '';
$endTime = is_scalar($eventPayload['end_time'] ?? null)
    ? substr((string) $eventPayload['end_time'], 0, 5)
    : '';
$location = is_scalar($eventPayload['location'] ?? null)
    ? trim((string) $eventPayload['location'])
    : '';
$description = is_scalar($eventPayload['description'] ?? null)
    ? trim((string) $eventPayload['description'])
    : '';
$link = is_array($eventPayload['link'] ?? null) ? $eventPayload['link'] : [];
?>

<article class="news-card news-event-card <?= ($index ?? null) === 0 ? 'news-event-card--featured' : '' ?>">
    <header class="news-event-card__header">
        <time class="news-event-card__date" datetime="<?= e($eventDate) ?>" aria-label="<?= e($eventDateLabel) ?>">
            <strong><?= e($eventDay) ?></strong>
            <span><?= e($eventMonth) ?></span>
            <?php if ($eventYear !== ''): ?>
                <small><?= e($eventYear) ?></small>
            <?php endif ?>
        </time>

        <div>
            <div class="news-event-card__eyebrow">
                <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                Wydarzenie
            </div>
            <h3><?= e($content->title ?? '') ?></h3>
        </div>
    </header>

    <div class="news-card__content news-event-card__body">
        <?php if ($description !== ''): ?>
            <p class="news-event-card__description"><?= e_br($description) ?></p>
        <?php endif ?>

        <dl class="news-event-card__meta">
            <?php if ($startTime !== ''): ?>
                <div>
                    <dt><i class="fa-regular fa-clock" aria-hidden="true"></i><span class="visually-hidden">Godzina</span></dt>
                    <dd><?= e($startTime) ?><?= $endTime !== '' ? ' – ' . e($endTime) : '' ?></dd>
                </div>
            <?php endif ?>

            <?php if ($location !== ''): ?>
                <div>
                    <dt><i class="fa-solid fa-location-dot" aria-hidden="true"></i><span class="visually-hidden">Miejsce</span></dt>
                    <dd><?= e($location) ?></dd>
                </div>
            <?php endif ?>
        </dl>

        <?php if (!empty($link['label']) && !empty($link['url'])): ?>
            <a class="news-event-card__link" href="<?= e($link['url']) ?>">
                <?= e($link['label']) ?>
                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
        <?php endif ?>
    </div>
</article>
