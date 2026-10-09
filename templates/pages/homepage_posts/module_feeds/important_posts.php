<?php
$createdTimestamp = strtotime((string) ($feedPost->created ?? ''));
$createdDate = $createdTimestamp
        ? date('d.m.Y', $createdTimestamp)
        : '';
?>

<article class="important-card club-notice">
    <div class="club-notice__header">
        <span class="club-notice__label">Komunikat</span>
        <?php if ($createdDate): ?>
            <time datetime="<?= e(date('Y-m-d', $createdTimestamp)) ?>"><?= e($createdDate) ?></time>
        <?php endif ?>
    </div>

    <div class="club-notice__body">
        <div class="important-card__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                <path d="M4 9h5l10-5v16L9 15H4a2 2 0 0 1-2-2v-2a2 2 0 0 1 2-2Z" />
                <path d="M7 15v5H4v-5M9 9v6M22 9v6" />
            </svg>
        </div>
        <h3><?= e($feedPost->title) ?></h3>
        <div class="important-card__content">
            <p data-notice-text><?= e_br($feedPost->description) ?></p>
            <button class="club-notice__toggle" type="button" aria-expanded="false" data-notice-toggle hidden>Rozwiń</button>
        </div>
    </div>
</article>
