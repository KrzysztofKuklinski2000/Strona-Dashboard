<?php
$feedPosts = is_array($feedPosts ?? null) ? $feedPosts : [];
$feedLimit = max(1, min(12, (int) ($block['limit'] ?? 3)));
$feedPosts = array_slice($feedPosts, 0, $feedLimit);

$sectionId = 'module-feed-section-' . (int) ($post->id ?? 0);
$titleId = $sectionId . '-title';
$sectionTitle = (string) ($post->title ?? 'Najnowsze aktualności');
?>

<?php if ($feedPosts): ?>
    <section
        id="<?= e($sectionId) ?>"
        class="important-section module-feed-section"
        aria-labelledby="<?= e($titleId) ?>"
        data-feed-slider
    >
        <div class="important-section__inner">
            <div class="important-section__heading">
                <p>Aktualności</p>
                <h2 id="<?= e($titleId) ?>"><?= e($sectionTitle) ?></h2>
            </div>

            <div class="important-info-shell" data-feed-slider-shell>
                <div
                    class="important-info"
                    tabindex="0"
                    aria-label="Lista aktualności"
                    data-feed-slider-list
                >
                    <?php foreach ($feedPosts as $index => $feedPost): ?>
                        <?php
                        $createdTimestamp = strtotime((string) ($feedPost->created ?? ''));
                        $createdDate = $createdTimestamp ? date('d.m.Y', $createdTimestamp) : '';
                        ?>

                        <article class="important-card">
                            <div class="important-card__icon" aria-hidden="true">
                                <i class="<?= $index % 2 === 0 ? 'fa-regular fa-calendar' : 'fa-regular fa-newspaper' ?>"></i>
                            </div>

                            <div class="important-card__content">
                                <p class="important-card__label">Aktualność</p>
                                <h3><?= e($feedPost->title ?? '') ?></h3>
                                <p><?= e_br($feedPost->description ?? '') ?></p>

                                <?php if ($createdDate !== ''): ?>
                                    <time datetime="<?= e(date('Y-m-d', $createdTimestamp)) ?>">
                                        <?= e($createdDate) ?>
                                    </time>
                                <?php endif ?>
                            </div>
                        </article>
                    <?php endforeach ?>
                </div>
            </div>

            <?php if (count($feedPosts) > 1): ?>
                <div class="info-arrows" aria-label="Nawigacja aktualności" data-feed-slider-controls>
                    <button class="left-arrow" type="button" aria-label="Poprzednie aktualności" data-feed-slider-previous>
                        <i class="fa-solid fa-angle-left" aria-hidden="true"></i>
                    </button>
                    <button class="right-arrow" type="button" aria-label="Następne aktualności" data-feed-slider-next>
                        <i class="fa-solid fa-angle-right" aria-hidden="true"></i>
                    </button>
                </div>
            <?php endif ?>
        </div>
    </section>
<?php endif ?>
