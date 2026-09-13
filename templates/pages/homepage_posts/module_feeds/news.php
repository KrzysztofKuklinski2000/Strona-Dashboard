<?php
$createdTimestamp = strtotime((string) ($feedPost->created ?? ''));
$createdDate = $createdTimestamp ? date('d.m.Y', $createdTimestamp) : '';
$payload = json_decode((string) ($feedPost->payload ?? ''), true);
$payload = is_array($payload) ? $payload : [];
$description = $payload['description'] ?? '';
$image = $payload['image'] ?? [];
$imageSrc = $image['src'] ?? '';
$imageAlt = trim((string) ($image['alt'] ?? ''));

if ($imageAlt === '') {
    $imageAlt = (string) ($feedPost->title ?? '');
}
?>

<article class="important-card module-feed-card module-feed-news-card">
    <div class="module-feed-card__meta">
        <span class="module-feed-card__icon" aria-hidden="true">
            <i class="fa-regular fa-newspaper"></i>
        </span>

        <?php if ($createdDate !== ''): ?>
            <time datetime="<?= e(date('Y-m-d', $createdTimestamp)) ?>">
                <?= e($createdDate) ?>
            </time>
        <?php endif ?>
    </div>

    <div class="module-feed-news-card__main <?= $imageSrc !== '' ? 'has-image' : '' ?>">
        <?php if ($imageSrc !== ''): ?>
            <div class="module-feed-news-card__media">
                <img src="<?= e($imageSrc) ?>" alt="<?= e($imageAlt) ?>" loading="lazy">
            </div>
        <?php endif ?>

        <div class="module-feed-card__content">
            <p class="module-feed-card__label">Wpis</p>
            <h3><?= e($feedPost->title ?? '') ?></h3>
            <p class="module-feed-card__description"><?= e_br($description) ?></p>
        </div>
    </div>
</article>
