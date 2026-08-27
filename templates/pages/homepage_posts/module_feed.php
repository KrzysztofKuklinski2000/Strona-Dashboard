<?php
$feedPosts = is_array($feedPosts ?? null) ? $feedPosts : [];
$feedLimit = max(1, min(12, (int) ($block['limit'] ?? 3)));
$feedPosts = array_slice($feedPosts, 0, $feedLimit);

$sectionId = 'module-feed-section-' . (int) ($post->id ?? 0);
$titleId = $sectionId . '-title';
$sectionTitle = (string) ($post->title ?? 'Najnowsze wpisy');

$moduleUrl = match ((string) ($block['module'] ?? '')) {
    'news' => '/aktualnosci',
    default => null,
};
?>

<?php if ($feedPosts): ?>
    <section
        id="<?= e($sectionId) ?>"
        class="important-section module-feed-section"
        aria-labelledby="<?= e($titleId) ?>"
        data-feed-slider
    >
        <div class="important-section__inner">
            <div class="module-feed-section__header">
                <div class="important-section__heading">
                    <p>Najnowsze wpisy</p>
                    <h2 id="<?= e($titleId) ?>"><?= e($sectionTitle) ?></h2>
                </div>

                <?php if ($moduleUrl !== null): ?>
                    <a class="module-feed-section__more" href="<?= e($moduleUrl) ?>">
                        Więcej
                        <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    </a>
                <?php endif ?>
            </div>

            <div class="important-info-shell" data-feed-slider-shell>
                <div
                    class="important-info"
                    tabindex="0"
                    aria-label="Lista wpisów"
                    data-feed-slider-list
                >
                    <?php foreach ($feedPosts as $feedPost): ?>
                        <?php
                        $createdTimestamp = strtotime((string) ($feedPost->created ?? ''));
                        $createdDate = $createdTimestamp ? date('d.m.Y', $createdTimestamp) : '';
                        ?>

                        <article class="important-card module-feed-card">
                            <div class="module-feed-card__meta">
                                <span class="module-feed-card__icon" aria-hidden="true">
                                    <i class="fa-regular fa-newspaper"></i>
                                </span>

                                <?php if ($createdDate !== ''): ?>
                                    <time datetime="<?= e(date('Y-m-d', $createdTimestamp)) ?>">
                                        <?= e($createdDate) ?>
                                    </time>
                                <?php endif ?>
                            </div>

                            <div class="module-feed-card__content">
                                <p class="module-feed-card__label">Wpis</p>
                                <h3><?= e($feedPost->title ?? '') ?></h3>
                                <p class="module-feed-card__description"><?= e_br($feedPost->description ?? '') ?></p>
                            </div>
                        </article>
                    <?php endforeach ?>
                </div>
            </div>

            <?php if (count($feedPosts) > 1): ?>
                <div class="info-arrows" aria-label="Nawigacja wpisów" data-feed-slider-controls>
                    <button class="left-arrow" type="button" aria-label="Poprzednie wpisy" data-feed-slider-previous>
                        <i class="fa-solid fa-angle-left" aria-hidden="true"></i>
                    </button>
                    <button class="right-arrow" type="button" aria-label="Następne wpisy" data-feed-slider-next>
                        <i class="fa-solid fa-angle-right" aria-hidden="true"></i>
                    </button>
                </div>
            <?php endif ?>
        </div>
    </section>
<?php endif ?>
