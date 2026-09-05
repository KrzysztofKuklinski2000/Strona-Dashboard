<?php
$createdTimestamp = strtotime((string) ($content->created ?? ''));
$createdDate = $createdTimestamp ? date('d.m.Y', $createdTimestamp) : '';
$createdDateTime = $createdTimestamp ? date('Y-m-d', $createdTimestamp) : '';
$imageName = $content->imageName ?? $content->image_name ?? null;
$description = $payload['description'] ?? '';
?>

<article class="news-card <?= ($index ?? null) === 0 ? 'news-card--featured' : '' ?>">
    <?php if ($imageName): ?>
        <div class="news-card__media">
            <img src="/public/uploads/<?= rawurlencode((string) $imageName) ?>" alt="<?= e($content->title) ?>" loading="lazy">
        </div>
    <?php else: ?>
        <div class="news-card__media news-card__media--fallback" aria-hidden="true">
            <i class="fa-regular fa-newspaper"></i>
        </div>
    <?php endif ?>

    <div class="news-card__content">
        <?php if ($createdDate): ?>
            <time datetime="<?= e($createdDateTime) ?>"><?= e($createdDate) ?></time>
        <?php endif ?>

        <h3><?= e($content->title) ?></h3>
        <p><?= e_br($description) ?></p>
    </div>
</article>
