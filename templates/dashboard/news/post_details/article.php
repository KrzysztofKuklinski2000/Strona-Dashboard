<?php
$description = $payload['description'] ?? '';
$image = $payload['image'] ?? [];
$imageSrc = $image['src'] ?? '';
$imageAlt = trim((string) ($image['alt'] ?? ''));

if ($imageAlt === '') {
    $imageAlt = (string) ($data->title ?? '');
}
?>

<h4><?= e($data->title ?? '') ?></h4>

<div class="news-article-details <?= $imageSrc === '' ? 'news-article-details--text-only' : '' ?>">
    <?php if ($imageSrc !== ''): ?>
        <figure class="news-article-details__media">
            <img src="<?= e($imageSrc) ?>" alt="<?= e($imageAlt) ?>">
        </figure>
    <?php endif ?>

    <?php if ($description !== ''): ?>
        <p class="homepage-post-details__description"><?= e_br($description) ?></p>
    <?php endif ?>
</div>
