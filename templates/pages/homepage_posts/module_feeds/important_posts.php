<?php
$createdTimestamp = strtotime((string) ($feedPost->created ?? ''));
$createdDate = $createdTimestamp
        ? date('d.m.Y', $createdTimestamp)
        : '';
?>

<article class="important-card">
    <div class="important-card__icon" aria-hidden="true">
        <i class="fa-regular fa-calendar"></i>
    </div>

    <div class="important-card__content">
        <p class="important-card__label">Ważne</p>
        <h3><?= e($feedPost->title) ?></h3>
        <p><?= e_br($feedPost->description) ?></p>

        <?php if ($createdDate): ?>
            <time datetime="<?= e(date('Y-m-d', $createdTimestamp)) ?>"><?= e($createdDate) ?></time>
        <?php endif ?>
    </div>
</article>