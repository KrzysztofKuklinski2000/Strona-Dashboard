<?php
$createdTimestamp = strtotime((string) ($content->created ?? ''));
$createdDate = $createdTimestamp ? date('d.m.Y', $createdTimestamp) : '';
$createdDateTime = $createdTimestamp ? date('Y-m-d', $createdTimestamp) : '';
$fundingSource = $payload['funding_source'] ?? '';
$amount = $payload['amount'] ?? '';
$description = $payload['description'] ?? '';
?>

<article class="news-card news-funding-card <?= ($index ?? null) === 0 ? 'news-card--featured news-funding-card--featured' : '' ?>">
    <header class="news-funding-card__visual">
        <span class="news-funding-card__icon" aria-hidden="true">
            <i class="fa-solid fa-hand-holding-dollar"></i>
        </span>

        <div class="news-funding-card__source">
            <span>Źródło finansowania</span>
            <strong><?= e($fundingSource !== '' ? $fundingSource : 'Wsparcie dla klubu') ?></strong>
        </div>
    </header>

    <div class="news-card__content news-funding-card__content">
        <div class="news-funding-card__heading">
            <span class="news-funding-card__eyebrow">Dofinansowanie</span>

            <?php if ($createdDate !== ''): ?>
                <time datetime="<?= e($createdDateTime) ?>"><?= e($createdDate) ?></time>
            <?php endif ?>
        </div>

        <h3><?= e($content->title ?? '') ?></h3>

        <?php if ($amount !== ''): ?>
            <div class="news-funding-card__amount">
                <span aria-hidden="true"><i class="fa-solid fa-coins"></i></span>
                <div>
                    <small>Kwota wsparcia</small>
                    <strong><?= e($amount) ?></strong>
                </div>
            </div>
        <?php endif ?>

        <?php if ($description !== ''): ?>
            <p class="news-funding-card__description"><?= e_br($description) ?></p>
        <?php endif ?>
    </div>
</article>
