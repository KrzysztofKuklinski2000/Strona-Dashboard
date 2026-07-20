<?php
use App\Content\MainPagePostTypes;

$first = $params['content'][2] ?? null;
$homePosts = $params['content'][0] ?? [];
$importantPosts = $params['content'][1] ?? [];
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

<?php if ($first): ?>
    <?php
    $firstPayload = json_decode((string) ($first->payload ?? ''), true);
    $firstPayload = is_array($firstPayload) ? $firstPayload : [];
    $firstDescription = (string) ($firstPayload['description'] ?? '');
    ?>
    <section class="first-class-section" aria-labelledby="first-class-title">
        <div class="first-class-section__inner">
            <div class="first-class-section__icon" aria-hidden="true">
                <i class="fa-solid fa-gift"></i>
            </div>

            <div class="first-class-section__content">
                <h2 id="first-class-title"><?= e($first->title ?? 'Pierwsze zajęcia są bezpłatne') ?></h2>

                <?php if ($firstDescription !== ''): ?>
                    <p><?= e_br($firstDescription) ?></p>
                <?php endif ?>
            </div>

            <a class="first-class-section__cta" href="/zapisy">
                Umów się na trening próbny
                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </section>
<?php endif ?>

<?php foreach ($homePosts as $postIndex => $post): ?>
    <?php
        $type = (string) ($post->type ?? MainPagePostTypes::SIMPLE_TEXT);
        $partial = MainPagePostTypes::partial($type);

        if ($partial === null) {
            $type = MainPagePostTypes::SIMPLE_TEXT;
            $partial = MainPagePostTypes::partial($type);
        }

        $partialPath = 'templates/pages/start_posts/' . $partial;
        $payload = json_decode((string) ($post->payload ?? ''), true) ?: [];
        $block = $payload;
        $sectionTone = $postIndex % 2 === 0
            ? 'home-post-section--soft'
            : 'home-post-section--paper';
    ?>

    <?php require $partialPath; ?>
<?php endforeach ?>

<script src="/public/js/scroll.js"></script>
