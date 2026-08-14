<?php
$detailItems = array_values(array_filter(
    is_array($payload['items'] ?? null) ? $payload['items'] : [],
    static fn(mixed $item): bool => is_scalar($item) && trim((string) $item) !== '',
));
$image = is_array($payload['image'] ?? null) ? $payload['image'] : [];
$link = is_array($payload['link'] ?? null) ? $payload['link'] : [];
$hasDetailLink = !empty($link['label']) && !empty($link['url']);
?>

<?php if (!empty($payload['eyebrow'])): ?>
    <p class="homepage-post-details__eyebrow"><?= e($payload['eyebrow']) ?></p>
<?php endif ?>

<h4><?= e($data->title ?? '') ?></h4>

<?php if (!empty($payload['description'])): ?>
    <p class="homepage-post-details__description"><?= nl2br(e($payload['description'])) ?></p>
<?php endif ?>

<div class="homepage-post-details__image-list <?= !$detailItems && !$hasDetailLink ? 'is-image-only' : '' ?>">
    <div class="homepage-post-details__image">
        <?php if (!empty($image['src'])): ?>
            <img src="<?= e($image['src']) ?>" alt="<?= e($image['alt'] ?? '') ?>">
        <?php else: ?>
            <i class="fa-regular fa-image" aria-hidden="true"></i>
            <span>Brak obrazu</span>
        <?php endif ?>
    </div>

    <?php if ($detailItems || $hasDetailLink): ?>
        <div>
            <?php if ($detailItems): ?>
                <ul>
                    <?php foreach ($detailItems as $item): ?>
                        <li><i class="fa-solid fa-check" aria-hidden="true"></i><?= e($item) ?></li>
                    <?php endforeach ?>
                </ul>
            <?php endif ?>

            <?php if ($hasDetailLink): ?>
                <p class="homepage-post-details__link"><i class="fa-solid fa-link" aria-hidden="true"></i><?= e($link['label']) ?> — <?= e($link['url']) ?></p>
            <?php endif ?>
        </div>
    <?php endif ?>
</div>
