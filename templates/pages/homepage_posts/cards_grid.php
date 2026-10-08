<?php
$sectionId = 'cards-grid-section-' . (int) ($post->id ?? 0);
$titleId = $sectionId . '-title';
$eyebrow = $block['eyebrow'] ?? '';
$title = $post->title ?? '';
$cards = $block['cards'] ?? [];
$cardCount = count($cards);
$gridSizeClass = $cardCount <= 2
    ? 'why-karate-grid--count-' . $cardCount
    : ($cardCount >= 4 ? 'why-karate-grid--many' : '');
?>

<?php if ($cards): ?>
    <section class="why-karate-section home-post-section" aria-labelledby="<?= e($titleId) ?>">
        <div class="why-karate-section__inner">
            <div class="why-karate-section__heading home-section-heading">
                <?php if ($eyebrow !== ''): ?>
                    <p class="home-section-eyebrow"><?= e($eyebrow) ?></p>
                <?php endif ?>

                <?php if ($title !== ''): ?>
                    <h2 class="home-section-title" id="<?= e($titleId) ?>"><?= e($title) ?></h2>
                <?php endif ?>
            </div>

            <div class="why-karate-grid <?= e($gridSizeClass) ?>">
                <?php foreach ($cards as $card): ?>
                    <article class="why-karate-card<?= !empty($card['icon']) ? ' why-karate-card--with-icon' : '' ?>">
                        <?php if (!empty($card['icon'])): ?>
                            <div class="why-karate-card__icon" aria-hidden="true">
                                <i class="<?= e($card['icon']) ?>"></i>
                            </div>
                        <?php endif ?>

                        <div class="why-karate-card__content">
                            <?php if (!empty($card['title'])): ?>
                                <h3><?= e($card['title']) ?></h3>
                            <?php endif ?>

                            <?php if (!empty($card['description'])): ?>
                                <p><?= e($card['description']) ?></p>
                            <?php endif ?>
                        </div>
                    </article>
                <?php endforeach ?>
            </div>
        </div>
    </section>
<?php endif ?>
