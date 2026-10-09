<?php
$titleId = 'trial-banner-title-' . (int) ($post->id ?? 0);
$description = (string) ($block['description'] ?? '');
$defaultDescription = 'Poznaj nasz klub i spróbuj treningu karate. Pierwsze zajęcia są bezpłatne — przyjdź, poćwicz z nami i zdecyduj, czy chcesz dołączyć.';
if ($description === '' || (
    str_contains($description, 'Chcesz spróbować, zanim się zdecydujesz?')
    && str_contains($description, 'Nie przegap okazji')
)) {
    $description = $defaultDescription;
}
?>
<section class="first-class-section home-post-section" aria-labelledby="<?= e($titleId) ?>">
    <div class="first-class-section__inner">
        <div class="first-class-section__icon" aria-hidden="true">
            <i class="fa-solid fa-gift"></i>
        </div>

        <div class="first-class-section__content">
            <h2 class="home-section-title" id="<?= e($titleId) ?>">
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
