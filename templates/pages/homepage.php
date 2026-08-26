<?php
use App\Content\HomepagePostTypes;

$content = $params['content'] ?? [];

$homepagePosts = $content['homepagePosts'] ?? [];
$importantPosts = $content['importantPosts'] ?? [];
$homepageFeeds = $content['homepageFeeds'] ?? [];
?>

<?php if ($importantPosts): ?>
    <section id="important-section" class="important-section" aria-labelledby="important-section-title">
        <div class="important-section__inner">
            <div class="important-section__heading">
                <p>Aktualne</p>
                <h2 id="important-section-title">Ważne informacje</h2>
            </div>

            <div class="important-info-shell">
                <div class="important-info" tabindex="0" aria-label="Lista ważnych informacji">
                    <?php foreach ($importantPosts as $key => $post): ?>
                        <?php
                        $createdTimestamp = strtotime($post->created ?? '');
                        $createdDate = $createdTimestamp ? date('d.m.Y', $createdTimestamp) : '';
                        ?>
                        <article class="important-card">
                            <div class="important-card__icon" aria-hidden="true">
                                <i class="<?= $key % 2 === 0 ? 'fa-regular fa-calendar' : 'fa-solid fa-info' ?>"></i>
                            </div>

                            <div class="important-card__content">
                                <p class="important-card__label">Ważne</p>
                                <h3><?= e($post->title) ?></h3>
                                <p><?= e_br($post->description) ?></p>

                                <?php if ($createdDate): ?>
                                    <time datetime="<?= e(date('Y-m-d', $createdTimestamp)) ?>"><?= e($createdDate) ?></time>
                                <?php endif ?>
                            </div>
                        </article>
                    <?php endforeach ?>
                </div>
            </div>

            <?php if (count($importantPosts) > 1): ?>
                <div class="info-arrows" aria-label="Nawigacja ważnych informacji">
                    <button class="left-arrow" type="button" aria-label="Poprzednie informacje">
                        <i class="fa-solid fa-angle-left" aria-hidden="true"></i>
                    </button>
                    <button class="right-arrow" type="button" aria-label="Następne informacje">
                        <i class="fa-solid fa-angle-right" aria-hidden="true"></i>
                    </button>
                </div>
            <?php endif ?>
        </div>
    </section>
<?php endif ?>

<?php foreach ($homepagePosts as $postIndex => $post): ?>
    <?php
        $type = (string) ($post->type ?? HomepagePostTypes::SIMPLE_TEXT);
        $partial = HomepagePostTypes::partial($type);
        $feedPosts = $homepageFeeds[$post->id] ?? [];

        if ($partial === null) {
            $type = HomepagePostTypes::SIMPLE_TEXT;
            $partial = HomepagePostTypes::partial($type);
        }

        $partialPath = 'templates/pages/homepage_posts/' . $partial;
        $payload = json_decode((string) ($post->payload ?? ''), true) ?: [];
        $block = $payload;
        $sectionTone = $postIndex % 2 === 0
            ? 'home-post-section--soft'
            : 'home-post-section--paper';
    ?>

    <?php require $partialPath; ?>
<?php endforeach ?>

<script src="/public/js/scroll.js"></script>
