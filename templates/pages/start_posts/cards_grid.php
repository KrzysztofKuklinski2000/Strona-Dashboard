<?php
$sectionId = $block['sectionId'] ?? 'cards-grid-section';
$titleId = $block['titleId'] ?? $sectionId . '-title';
$eyebrow = $block['eyebrow'] ?? '';
$title = $block['title'] ?? '';
$cards = $block['cards'] ?? [];
?>

<?php if ($cards): ?>
    <section class="why-karate-section" aria-labelledby="<?= e($titleId) ?>">
        <div class="why-karate-section__inner">
            <div class="why-karate-section__heading">
                <?php if ($eyebrow !== ''): ?>
                    <p><?= e($eyebrow) ?></p>
                <?php endif ?>

                <?php if ($title !== ''): ?>
                    <h2 id="<?= e($titleId) ?>"><?= e($title) ?></h2>
                <?php endif ?>
            </div>

            <div class="why-karate-grid">
                <?php foreach ($cards as $card): ?>
                    <article class="why-karate-card">
                        <?php if (!empty($card['icon'])): ?>
                            <div class="why-karate-card__icon" aria-hidden="true">
                                <i class="<?= e($card['icon']) ?>"></i>
                            </div>
                        <?php endif ?>

                        <div>
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
