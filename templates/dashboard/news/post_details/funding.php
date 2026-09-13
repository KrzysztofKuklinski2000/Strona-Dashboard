<?php
$fundingSource = $payload['funding_source'] ?? '';
$amount = $payload['amount'] ?? '';
$description = $payload['description'] ?? '';
?>

<div class="news-funding-details">
    <p class="homepage-post-details__eyebrow">
        <i class="fa-solid fa-hand-holding-dollar" aria-hidden="true"></i>
        Dofinansowanie
    </p>

    <h4><?= e($data->title ?? '') ?></h4>

    <div class="homepage-post-details__cards news-funding-details__meta">
        <div class="homepage-post-details__card">
            <i class="fa-solid fa-building-columns" aria-hidden="true"></i>
            <strong>Źródło finansowania</strong>
            <p><?= e($fundingSource) ?></p>
        </div>

        <?php if ($amount !== ''): ?>
            <div class="homepage-post-details__card news-funding-details__amount">
                <i class="fa-solid fa-coins" aria-hidden="true"></i>
                <strong>Kwota</strong>
                <p><?= e($amount) ?></p>
            </div>
        <?php endif ?>
    </div>

    <?php if ($description !== ''): ?>
        <p class="homepage-post-details__description news-funding-details__description">
            <?= e_br($description) ?>
        </p>
    <?php endif ?>
</div>
