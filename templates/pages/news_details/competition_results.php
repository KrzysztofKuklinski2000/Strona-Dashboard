<?php
$competitionDate = is_scalar($payload['competition_date'] ?? null)
    ? (string) $payload['competition_date']
    : '';
$competitionTimestamp = $competitionDate !== '' ? strtotime($competitionDate) : false;
$competitionDateLabel = $competitionTimestamp ? date('d.m.Y', $competitionTimestamp) : '';
$location = is_scalar($payload['location'] ?? null) ? trim((string) $payload['location']) : '';
$description = is_scalar($payload['description'] ?? null) ? trim((string) $payload['description']) : '';
$results = is_array($payload['results'] ?? null) ? $payload['results'] : [];
$link = is_array($payload['link'] ?? null) ? $payload['link'] : [];
?>

<div class="news-detail news-detail--results">
    <header class="news-detail-results__header">
        <span class="news-detail__icon" aria-hidden="true">
            <i class="fa-solid fa-trophy"></i>
        </span>
        <div>
            <p class="news-detail__eyebrow">Wyniki zawodów</p>
            <div class="news-detail-results__meta">
                <?php if ($competitionDateLabel !== ''): ?>
                    <time datetime="<?= e($competitionDate) ?>">
                        <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                        <?= e($competitionDateLabel) ?>
                    </time>
                <?php endif ?>

                <?php if ($location !== ''): ?>
                    <span>
                        <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                        <?= e($location) ?>
                    </span>
                <?php endif ?>
            </div>
        </div>
    </header>

    <div class="news-detail-results__body">
        <?php if ($description !== ''): ?>
            <div class="news-detail__prose"><?= e_br($description) ?></div>
        <?php endif ?>

        <?php if ($results !== []): ?>
            <div class="news-detail-results__list" aria-label="Lista wyników">
                <?php foreach ($results as $result): ?>
                    <?php
                    $result = is_array($result) ? $result : [];
                    $place = is_scalar($result['place'] ?? null) ? trim((string) $result['place']) : '';
                    $competitor = is_scalar($result['competitor'] ?? null) ? trim((string) $result['competitor']) : '';
                    $category = is_scalar($result['category'] ?? null) ? trim((string) $result['category']) : '';

                    if ($place === '' && $competitor === '' && $category === '') {
                        continue;
                    }
                    ?>

                    <div class="news-detail-result">
                        <strong><?= e($place !== '' ? $place : '–') ?></strong>
                        <div>
                            <span><?= e($competitor !== '' ? $competitor : 'Nie podano zawodnika') ?></span>
                            <?php if ($category !== ''): ?>
                                <small><?= e($category) ?></small>
                            <?php endif ?>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>

        <?php if (!empty($link['label']) && !empty($link['url'])): ?>
            <a class="news-detail__primary-link" href="<?= e($link['url']) ?>">
                <?= e($link['label']) ?>
                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
        <?php endif ?>
    </div>
</div>
