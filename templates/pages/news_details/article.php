<?php
$description = is_scalar($payload['description'] ?? null)
    ? trim((string) $payload['description'])
    : '';
$image = is_array($payload['image'] ?? null) ? $payload['image'] : [];
$imageSrc = is_scalar($image['src'] ?? null) ? trim((string) $image['src']) : '';
$imageAlt = is_scalar($image['alt'] ?? null) ? trim((string) $image['alt']) : '';

if ($imageAlt === '') {
    $imageAlt = (string) ($post->title ?? '');
}
?>

<div class="news-detail news-detail--article <?= $imageSrc === '' ? 'news-detail--without-media' : '' ?>">
    <?php if ($imageSrc !== ''): ?>
        <figure class="news-detail__media">
            <img src="<?= e($imageSrc) ?>" alt="<?= e($imageAlt) ?>">
        </figure>
    <?php endif ?>

    <div class="news-detail__copy">
        <p class="news-detail__eyebrow">Artykuł klubowy</p>

        <?php if ($description !== ''): ?>
            <div class="news-detail__prose"><?= e_br($description) ?></div>
        <?php endif ?>
    </div>
</div>
