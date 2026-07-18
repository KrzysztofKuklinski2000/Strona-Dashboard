<?php
$sectionId = 'simple-text-section-' . (int) ($post->id ?? 0);
$titleId = $sectionId . '-title';
$title = $post->title ?? '';
$description = $post->description ?? '';
?>

<section id="<?= e($sectionId) ?>" class="simple-text-section home-post-section <?= e($sectionTone ?? 'home-post-section--soft') ?>" aria-labelledby="<?= e($titleId) ?>">
    <div class="simple-text-section__inner">
        <div class="simple-text-section__heading">
            <?php if ($title !== ''): ?>
                <h2 id="<?= e($titleId) ?>"><?= e($title) ?></h2>
            <?php endif ?>
        </div>

        <?php if ($description !== ''): ?>
            <div class="simple-text-section__content">
                <p><?= e_br($description) ?></p>
            </div>
        <?php endif ?>
    </div>
</section>
