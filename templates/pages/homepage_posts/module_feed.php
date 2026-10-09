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
            <div class="module-feed-section__header">
                <div class="important-section__heading home-section-heading">
                    <p class="home-section-eyebrow"><?= e($sectionEyebrow) ?></p>
                    <h2 class="home-section-title" id="<?= e($titleId) ?>"><?= e($sectionTitle) ?></h2>
                </div>

                <?php if ($isImportantFeed): ?>
                    <p class="club-notices-intro">Tutaj znajdziesz najważniejsze komunikaty dotyczące życia naszego klubu: zmiany w grafiku treningów, informacje o wydarzeniach i sprawach organizacyjnych. Sprawdź aktualne ogłoszenia, aby być na bieżąco i dobrze przygotować się do kolejnych zajęć.</p>
                <?php endif ?>

                <?php if ($isNewsFeed): ?>
                    <p class="module-feed-news-intro">
                        Relacje z zawodów, informacje organizacyjne i codzienne życie naszego klubu — wszystko w jednym miejscu.
                    </p>

                    <ul class="module-feed-news-topics" aria-label="Tematy aktualności">
                        <li title="Zawody"><i class="fa-solid fa-trophy" aria-hidden="true"></i><span class="visually-hidden">Zawody</span></li>
                        <li title="Wydarzenia"><i class="fa-solid fa-calendar-days" aria-hidden="true"></i><span class="visually-hidden">Wydarzenia</span></li>
                        <li title="Życie klubu"><i class="fa-solid fa-people-group" aria-hidden="true"></i><span class="visually-hidden">Życie klubu</span></li>
                    </ul>
                <?php endif ?>

                <?php if (!$isNewsFeed && $module !== null && $module['url'] !== null): ?>
                    <a class="module-feed-section__more" href="<?= e($module['url']) ?>">
                        Więcej
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
                    <div class="info-arrows" aria-label="Nawigacja wpisów" data-feed-slider-controls>
                        <button class="left-arrow" type="button" aria-label="Poprzednie wpisy" data-feed-slider-previous>
                            <i class="fa-solid fa-angle-left" aria-hidden="true"></i>
                        </button>
                        <button class="right-arrow" type="button" aria-label="Następne wpisy" data-feed-slider-next>
                            <i class="fa-solid fa-angle-right" aria-hidden="true"></i>
                        </button>
                    </div>

                    <?php if ($isNewsFeed || $isImportantFeed): ?>
                        <div
                            class="module-feed-section__pagination"
                            aria-label="Pozycje komunikatów"
                            data-feed-slider-pagination
                        ></div>
                    <?php endif ?>
                <?php endif ?>
            </div>

            <?php if ($isNewsFeed && $module !== null && $module['url'] !== null): ?>
                <a class="module-feed-section__more module-feed-section__more--footer" href="<?= e($module['url']) ?>">
                    Wszystkie aktualności
                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>
            <?php endif ?>
        </div>
    </section>
<?php endif ?>
