<?php

use App\Content\HomepageFeedModules;

$feedPosts = is_array($feedPosts ?? null) ? $feedPosts : [];
$feedLimit = max(1, min(12, (int) ($block['limit'] ?? 3)));
$feedPosts = array_slice($feedPosts, 0, $feedLimit);

$sectionId = 'module-feed-section-' . (int) ($post->id ?? 0);
$titleId = $sectionId . '-title';
$sectionTitle = (string) ($post->title ?? 'Najnowsze wpisy');

$module = HomepageFeedModules::get($block['module'] ?? '');
$feedPartial = $module['partial'] ?? '';

?>

<?php if ($feedPosts): ?>
    <section
        id="<?= e($sectionId) ?>"
        class="important-section module-feed-section"
        aria-labelledby="<?= e($titleId) ?>"
        data-feed-slider
        data-feed-module="<?= e((string) ($block['module'] ?? '')) ?>"
    >
        <div class="important-section__inner">
            <div class="module-feed-section__header">
                <div class="important-section__heading">
                    <p>Najnowsze wpisy</p>
                    <h2 id="<?= e($titleId) ?>"><?= e($sectionTitle) ?></h2>
                </div>

                <?php if ($module !== null && $module['url'] !== null): ?>
                    <a class="module-feed-section__more" href="<?= e($module['url']) ?>">
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
                        <?php require 'templates/pages/homepage_posts/module_feeds/'. $feedPartial;  ?>
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
