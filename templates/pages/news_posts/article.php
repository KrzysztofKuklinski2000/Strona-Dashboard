<?php
$description = $payload['description'] ?? '';
$image = $payload['image'] ?? [];
$imageSrc = $image['src'] ?? '';
$imageAlt = trim((string) ($image['alt'] ?? ''));

if ($imageAlt === '') {
    $imageAlt = (string) ($content->title ?? '');
}
?>

<article class="news-card <?= ($index ?? null) === 0 ? 'news-card--featured' : '' ?>">
    <?php if ($imageSrc !== ''): ?>
        <div class="news-card__media">
            <img src="<?= e($imageSrc) ?>" alt="<?= e($imageAlt) ?>" loading="lazy">
        </div>
    <?php else: ?>
        <div class="news-card__media news-card__media--fallback" aria-hidden="true">
            <i class="fa-regular fa-newspaper"></i>
        </div>
    <?php endif ?>

    <div class="news-card__content">
        <h3><?= e($content->title) ?></h3>
        <p><?= e_br($description) ?></p>

        <a class="news-card__details-link" href="<?= e($detailsUrl) ?>">
            Zobacz szczegóły
            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
        </a>
    </div>
</article>
