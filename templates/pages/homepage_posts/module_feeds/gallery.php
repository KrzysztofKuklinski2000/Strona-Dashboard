<?php
$categoryLabel = match ($feedPost->category ?? null) {
    'training' => 'Treningi',
    'camp' => 'Obozy',
    default => 'Galeria',
};

$description = trim((string) ($feedPost->description ?? ''));
$imageDescription = $description !== ''
    ? $description
    : 'Zdjęcie z galerii klubowej';

$imagePath = '/public/uploads/' . rawurlencode((string) $feedPost->imageName);
?>

<article class="important-card module-feed-gallery-card">
    <img
        class="module-feed-gallery-card__image"
        src="<?= e($imagePath) ?>"
        alt="<?= e($imageDescription) ?>"
        loading="lazy"
    >

    <div class="module-feed-gallery-card__content">
        <p><?= e($categoryLabel) ?></p>
        <h3><?= e($imageDescription) ?></h3>
    </div>
</article>