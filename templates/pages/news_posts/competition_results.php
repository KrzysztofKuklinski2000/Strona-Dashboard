<?php
$resultsPayload = isset($payload) && is_array($payload)
    ? $payload
    : (json_decode((string) ($content->payload ?? ''), true) ?: []);

$competitionDate = is_scalar($resultsPayload['competition_date'] ?? null)
    ? (string) $resultsPayload['competition_date']
    : '';
$competitionTimestamp = $competitionDate !== '' ? strtotime($competitionDate) : false;
$competitionDateLabel = $competitionTimestamp ? date('d.m.Y', $competitionTimestamp) : '';
$location = is_scalar($resultsPayload['location'] ?? null)
    ? trim((string) $resultsPayload['location'])
    : '';
$description = is_scalar($resultsPayload['description'] ?? null)
    ? trim((string) $resultsPayload['description'])
    : '';
$results = is_array($resultsPayload['results'] ?? null) ? $resultsPayload['results'] : [];
$link = is_array($resultsPayload['link'] ?? null) ? $resultsPayload['link'] : [];
?>

<article class="news-card news-results-card <?= ($index ?? null) === 0 ? 'news-results-card--featured' : '' ?>">
    <header class="news-results-card__header">
        <div class="news-results-card__icon" aria-hidden="true">
            <i class="fa-solid fa-trophy"></i>
        </div>

        <div>
            <div class="news-results-card__eyebrow">Wyniki zawodów</div>
            <h3><?= e($content->title ?? '') ?></h3>

            <?php if ($competitionDateLabel !== '' || $location !== ''): ?>
                <div class="news-results-card__meta">
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
            <?php endif ?>
        </div>
    </header>

    <div class="news-card__content news-results-card__body">
        <?php if ($description !== ''): ?>
            <p class="news-results-card__description"><?= e_br($description) ?></p>
        <?php endif ?>

        <?php if ($results !== []): ?>
            <div class="news-results-card__list">
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

                    <div class="news-results-card__result">
                        <strong><?= e($place !== '' ? $place : '—') ?></strong>
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
            <a class="news-results-card__link" href="<?= e($link['url']) ?>">
                <?= e($link['label']) ?>
                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
        <?php endif ?>
    </div>
</article>
