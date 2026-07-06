<?php
$sectionId = $block['sectionId'] ?? 'image-text-list-section';
$titleId = $block['titleId'] ?? $sectionId . '-title';
$eyebrow = $block['eyebrow'] ?? '';
$title = $post->title ?? '';
$description = $post->description ?? '';
$image = $block['image'] ?? null;
$items = $block['items'] ?? [];
$link = $block['link'] ?? null;
?>

<section id="<?= e($sectionId) ?>" class="family-training-section" aria-labelledby="<?= e($titleId) ?>">
    <div class="family-training-section__inner">
        <?php if (!empty($image['src'])): ?>
            <div class="family-training-section__media">
                <img src="<?= e($image['src']) ?>" alt="<?= e($image['alt'] ?? '') ?>">
            </div>
        <?php endif ?>

        <div class="family-training-section__content">
            <?php if ($eyebrow !== ''): ?>
                <p class="family-training-section__eyebrow"><?= e($eyebrow) ?></p>
            <?php endif ?>

            <?php if ($title !== ''): ?>
                <h2 id="<?= e($titleId) ?>"><?= e($title) ?></h2>
            <?php endif ?>

            <?php if ($description !== ''): ?>
                <p class="family-training-section__lead"><?= e($description) ?></p>
            <?php endif ?>

            <?php if ($items): ?>
                <ul class="family-training-section__list">
                    <?php foreach ($items as $item): ?>
                        <li>
                            <i class="fa-solid fa-check" aria-hidden="true"></i>
                            <?= e($item) ?>
                        </li>
                    <?php endforeach ?>
                </ul>
            <?php endif ?>

            <?php if (!empty($link['url']) && !empty($link['label'])): ?>
                <a class="family-training-section__cta" href="<?= e($link['url']) ?>">
                    <?= e($link['label']) ?>
                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>
            <?php endif ?>
        </div>
    </div>
</section>
