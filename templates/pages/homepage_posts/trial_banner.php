<?php
$titleId = 'trial-banner-title-' . (int) ($post->id ?? 0);
$description = (string) ($block['description'] ?? '');
?>
<section class="first-class-section" aria-labelledby="<?= e($titleId) ?>">
    <div class="first-class-section__inner">
        <div class="first-class-section__icon" aria-hidden="true">
            <i class="fa-solid fa-gift"></i>
        </div>

        <div class="first-class-section__content">
            <h2 id="<?= e($titleId) ?>">
                <?= e($post->title ?? 'Pierwsze zajęcia są bezpłatne') ?>
            </h2>

            <?php if ($description !== ''): ?>
                <p><?= e_br($description) ?></p>
            <?php endif ?>
        </div>

        <a class="first-class-section__cta" href="/zapisy">
            Umów się na trening próbny
            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
        </a>
    </div>
</section>