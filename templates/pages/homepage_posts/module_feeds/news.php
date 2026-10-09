<?php
$createdTimestamp = strtotime((string) ($feedPost->created ?? ''));
$createdDate = $createdTimestamp ? date('d.m.Y', $createdTimestamp) : '';
$payload = json_decode((string) ($feedPost->payload ?? ''), true);
$payload = is_array($payload) ? $payload : [];
$image = $payload['image'] ?? [];
$imageSrc = $image['src'] ?? '';
$imageAlt = trim((string) ($image['alt'] ?? ''));

if ($imageAlt === '') {
    $imageAlt = (string) ($feedPost->title ?? '');
}
?>

<article class="important-card module-feed-card module-feed-news-card <?= $imageSrc === '' ? 'module-feed-news-card--without-image' : '' ?>">
    <a class="module-feed-news-card__link" href="/aktualnosci/wpis/<?= (int) ($feedPost->id ?? 0) ?>">
        <?php if ($imageSrc !== ''): ?>
            <div class="module-feed-news-card__media">
                <img src="<?= e($imageSrc) ?>" alt="<?= e($imageAlt) ?>" loading="lazy">
            </div>
        <?php else: ?>
            <div class="module-feed-news-card__media module-feed-news-card__media--placeholder" aria-hidden="true">
                <img src="/public/images/logo1.png" alt="">
                <span>Klub Karate Kyokushin</span>
            </div>
        <?php endif ?>

        <div class="module-feed-news-card__body">
            <?php if ($createdDate !== ''): ?>
                <time datetime="<?= e(date('Y-m-d', $createdTimestamp)) ?>">
                    <?= e($createdDate) ?>
                </time>
            <?php endif ?>

            <h3><?= e($feedPost->title ?? '') ?></h3>
            <span class="module-feed-news-card__read-more">
                Czytaj
                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </span>
        </div>
    </a>
</article>
