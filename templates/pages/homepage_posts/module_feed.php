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
$sectionEyebrow = (string) ($module['eyebrow'] ?? 'Najnowsze wpisy');
$isNewsFeed = ($block['module'] ?? '') === 'news';
$isImportantFeed = ($block['module'] ?? '') === 'important_posts';
$isTimetableFeed = ($block['module'] ?? '') === 'timetable';
$isGalleryFeed = ($block['module'] ?? '') === 'gallery';
$hasMoreLink = $module !== null && $module['url'] !== null;

?>

<?php if ($feedPosts): ?>
    <section
        id="<?= e($sectionId) ?>"
        class="important-section module-feed-section home-post-section"
        aria-labelledby="<?= e($titleId) ?>"
        data-feed-slider
        data-feed-module="<?= e((string) ($block['module'] ?? '')) ?>"
        data-feed-count="<?= count($feedPosts) ?>"
    >
        <div class="important-section__inner">
            <div class="module-feed-section__header<?= $hasMoreLink ? ' module-feed-section__header--with-link' : '' ?>">
                <div class="module-feed-section__intro">
                    <div class="important-section__heading home-section-heading">
                        <p class="home-section-eyebrow"><?= e($sectionEyebrow) ?></p>
                        <h2 class="home-section-title" id="<?= e($titleId) ?>"><?= e($sectionTitle) ?></h2>
                    </div>

                    <?php if ($isImportantFeed): ?>
                        <p class="club-notices-intro">Zmiany w grafiku, zapisy i sprawy organizacyjne — sprawdź aktualne komunikaty klubu.</p>
                    <?php endif ?>

                    <?php if ($isNewsFeed): ?>
                        <p class="module-feed-news-intro">
                            Relacje z zawodów, informacje organizacyjne i codzienne życie naszego klubu — wszystko w jednym miejscu.
                        </p>
                    <?php endif ?>

                    <?php if ($isTimetableFeed): ?>
                        <p class="module-feed-timetable-intro">Znajdź trening dla swojej grupy i sprawdź, kiedy i gdzie się spotykamy. W grafiku znajdziesz godziny zajęć i adresy sal.</p>
                    <?php endif ?>

                    <?php if ($isGalleryFeed): ?>
                        <p class="module-feed-gallery-intro">Zobacz nasz klub w ruchu. Na treningach, zawodach i obozach. W galerii zbieramy wspólne chwile, sportowe emocje i codzienne życie naszej społeczności.</p>
                    <?php endif ?>
                </div>

                <?php if ($hasMoreLink): ?>
                    <a class="module-feed-section__more module-feed-section__more--header" href="<?= e($module['url']) ?>">
                        <?= $isTimetableFeed ? 'Zobacz pełny grafik' : ($isGalleryFeed ? 'Zobacz całą galerię' : 'Wszystkie aktualności') ?>
                        <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    </a>
                <?php endif ?>
            </div>

            <div class="module-feed-section__slider">
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
                    <div class="module-feed-section__navigation" aria-label="Nawigacja wpisów" data-feed-slider-controls>
                        <button class="left-arrow" type="button" aria-label="Poprzednie wpisy" data-feed-slider-previous>
                            <i class="fa-solid fa-angle-left" aria-hidden="true"></i>
                        </button>

                        <div
                            class="module-feed-section__pagination"
                            aria-label="Pozycje slidera"
                            data-feed-slider-pagination
                        ></div>

                        <button class="right-arrow" type="button" aria-label="Następne wpisy" data-feed-slider-next>
                            <i class="fa-solid fa-angle-right" aria-hidden="true"></i>
                        </button>
                    </div>
                <?php endif ?>
            </div>

        </div>
    </section>
<?php endif ?>
