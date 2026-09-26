<?php
$eventDate = is_scalar($payload['event_date'] ?? null) ? (string) $payload['event_date'] : '';
$eventTimestamp = $eventDate !== '' ? strtotime($eventDate) : false;
$eventDateLabel = $eventTimestamp ? date('d.m.Y', $eventTimestamp) : 'Termin do ustalenia';
$startTime = is_scalar($payload['start_time'] ?? null) ? substr((string) $payload['start_time'], 0, 5) : '';
$endTime = is_scalar($payload['end_time'] ?? null) ? substr((string) $payload['end_time'], 0, 5) : '';
$location = is_scalar($payload['location'] ?? null) ? trim((string) $payload['location']) : '';
$description = is_scalar($payload['description'] ?? null) ? trim((string) $payload['description']) : '';
$link = is_array($payload['link'] ?? null) ? $payload['link'] : [];
?>

<div class="news-detail news-detail--event">
    <header class="news-detail-event__summary">
        <span class="news-detail__icon" aria-hidden="true">
            <i class="fa-regular fa-calendar-check"></i>
        </span>
        <div>
            <p class="news-detail__eyebrow">Wydarzenie klubowe</p>
            <strong><?= e($eventDateLabel) ?></strong>
        </div>
    </header>

    <div class="news-detail-event__body">
        <?php if ($description !== ''): ?>
            <div class="news-detail__prose"><?= e_br($description) ?></div>
        <?php endif ?>

        <dl class="news-detail__facts">
            <div>
                <dt><i class="fa-regular fa-calendar" aria-hidden="true"></i> Data</dt>
                <dd><?= e($eventDateLabel) ?></dd>
            </div>

            <?php if ($startTime !== ''): ?>
                <div>
                    <dt><i class="fa-regular fa-clock" aria-hidden="true"></i> Godzina</dt>
                    <dd><?= e($startTime) ?><?= $endTime !== '' ? ' – ' . e($endTime) : '' ?></dd>
                </div>
            <?php endif ?>

            <?php if ($location !== ''): ?>
                <div>
                    <dt><i class="fa-solid fa-location-dot" aria-hidden="true"></i> Miejsce</dt>
                    <dd><?= e($location) ?></dd>
                </div>
            <?php endif ?>
        </dl>

        <?php if (!empty($link['label']) && !empty($link['url'])): ?>
            <a class="news-detail__primary-link" href="<?= e($link['url']) ?>">
                <?= e($link['label']) ?>
                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
        <?php endif ?>
    </div>
</div>
