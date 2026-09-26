<?php
$fundingSource = is_scalar($payload['funding_source'] ?? null)
    ? trim((string) $payload['funding_source'])
    : '';
$amount = is_scalar($payload['amount'] ?? null) ? trim((string) $payload['amount']) : '';
$description = is_scalar($payload['description'] ?? null) ? trim((string) $payload['description']) : '';
?>

<div class="news-detail news-detail--funding">
    <header class="news-detail-funding__header">
        <span class="news-detail__icon" aria-hidden="true">
            <i class="fa-solid fa-hand-holding-dollar"></i>
        </span>

        <div>
            <p class="news-detail__eyebrow">Wsparcie klubu</p>
            <strong><?= e($fundingSource !== '' ? $fundingSource : 'Informacja o dofinansowaniu') ?></strong>
        </div>
    </header>

    <div class="news-detail-funding__body">
        <?php if ($amount !== ''): ?>
            <div class="news-detail-funding__amount">
                <span aria-hidden="true"><i class="fa-solid fa-coins"></i></span>
                <div>
                    <small>Kwota wsparcia</small>
                    <strong><?= e($amount) ?></strong>
                </div>
            </div>
        <?php endif ?>

        <?php if ($description !== ''): ?>
            <div class="news-detail__prose"><?= e_br($description) ?></div>
        <?php endif ?>
    </div>
</div>
