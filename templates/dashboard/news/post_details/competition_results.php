<?php
$competitionDate = is_scalar($payload['competition_date'] ?? null)
    ? (string) $payload['competition_date']
    : '';
$competitionTimestamp = $competitionDate !== '' ? strtotime($competitionDate) : false;
$competitionDateLabel = $competitionTimestamp ? date('d.m.Y', $competitionTimestamp) : 'Nie podano';
$location = is_scalar($payload['location'] ?? null) ? trim((string) $payload['location']) : '';
$description = is_scalar($payload['description'] ?? null) ? trim((string) $payload['description']) : '';
$results = is_array($payload['results'] ?? null) ? $payload['results'] : [];
$link = is_array($payload['link'] ?? null) ? $payload['link'] : [];
?>

<div class="homepage-post-details__image-list news-results-details">
    <div class="news-results-details__summary">
        <i class="fa-solid fa-trophy" aria-hidden="true"></i>
        <span>Wyniki zawodów</span>
        <?php if ($competitionDate !== ''): ?>
            <time datetime="<?= e($competitionDate) ?>"><?= e($competitionDateLabel) ?></time>
        <?php else: ?>
            <strong><?= e($competitionDateLabel) ?></strong>
        <?php endif ?>
        <?php if ($location !== ''): ?>
            <small><i class="fa-solid fa-location-dot" aria-hidden="true"></i><?= e($location) ?></small>
        <?php endif ?>
    </div>

    <div>
        <p class="homepage-post-details__eyebrow">Wyniki zawodów</p>
        <h4><?= e($data->title ?? '') ?></h4>

        <?php if ($description !== ''): ?>
            <p class="homepage-post-details__description"><?= e_br($description) ?></p>
        <?php endif ?>

        <?php if ($results !== []): ?>
            <div class="news-results-details__list">
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

                    <div class="news-results-details__result">
                        <strong><?= e($place !== '' ? $place : '—') ?></strong>
                        <div>
                            <p><?= e($competitor !== '' ? $competitor : 'Nie podano zawodnika') ?></p>
                            <?php if ($category !== ''): ?>
                                <small><?= e($category) ?></small>
                            <?php endif ?>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>

        <?php if (!empty($link['label']) && !empty($link['url'])): ?>
            <p class="homepage-post-details__link">
                <i class="fa-solid fa-link" aria-hidden="true"></i>
                <?= e($link['label']) ?> — <?= e($link['url']) ?>
            </p>
        <?php endif ?>
    </div>
</div>
