<?php
$first = $params['content'][2] ?? null;
$importantPosts = array_values(array_filter(
    $params['content'][1] ?? [],
    static fn($post): bool => (bool) ($post->status ?? false)
));
?>

<?php if ($importantPosts): ?>
    <section id="important-section" class="important-section" aria-labelledby="important-section-title">
        <div class="important-section__inner">
            <div class="important-section__heading">
                <p>Aktualne</p>
                <h2 id="important-section-title">Ważne informacje</h2>
            </div>

            <div class="important-info" tabindex="0" aria-label="Lista ważnych informacji">
                <?php foreach($importantPosts as $key => $post): ?>
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

<?php if($first): ?>
    <section class="first-class-section" aria-labelledby="first-class-title">
        <div class="first-class-section__inner">
            <div class="first-class-section__icon" aria-hidden="true">
                <i class="fa-solid fa-gift"></i>
            </div>

            <div class="first-class-section__content">
                <h2 id="first-class-title"><?= e($first->title ?? 'Pierwsze zajęcia są bezpłatne') ?></h2>

                <?php if (!empty($first->description)): ?>
                    <p><?= e_br($first->description) ?></p>
                <?php endif ?>
            </div>

            <a class="first-class-section__cta" href="/zapisy">
                Umów się na trening próbny
                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </section>
<?php endif ?>

<div class="padding-top">
        <?php foreach($params['content'][0] ?? [] as  $content): ?>
            <?php if($content->status): ?>
                <?php $class = $content->id % 2 === 0 ? "dark-post" : 'light-post'  ?>
                <div class="post">
                    <?php
                        $text = $content->title;
                        require('templates/components/post_header.php');
                    ?>
                    <div class="post-content flex-item-center <?= $class ?>">
                        <p><?= e_br($content->description) ?></p>
                    </div>
                </div>
            <?php endif ?>
        <?php endforeach ?>
    </div>

<script src="/public/js/scroll.js"></script>
