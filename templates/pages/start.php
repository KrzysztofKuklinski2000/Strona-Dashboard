<?php
$first = $params['content'][2] ?? null;
$homePosts = array_values(array_filter(
    $params['content'][0] ?? [],
    static fn($post): bool => (bool) ($post->status ?? false)
));
$legacyHomePosts = array_values(array_filter(
    $homePosts,
    static fn($post): bool => !preg_match('/dlaczego\s+karate/i', (string) ($post->title ?? ''))
));
$importantPosts = array_values(array_filter(
    $params['content'][1] ?? [],
    static fn($post): bool => (bool) ($post->status ?? false)
));
$whyKarateCards = [
    [
        'icon' => 'fa-solid fa-child-reaching',
        'title' => 'Siła i sprawność',
        'description' => 'Poprawiamy kondycję, gibkość i koordynację. Budujemy zdrowe nawyki na całe życie.',
    ],
    [
        'icon' => 'fa-solid fa-shield-halved',
        'title' => 'Charakter i dyscyplina',
        'description' => 'Uczymy szacunku, wytrwałości i odpowiedzialności - na macie i poza nią.',
    ],
    [
        'icon' => 'fa-solid fa-people-group',
        'title' => 'Społeczność',
        'description' => 'Trenujemy razem, wspieramy się i tworzymy przyjazną atmosferę w każdym wieku.',
    ],
];
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

<section class="why-karate-section" aria-labelledby="why-karate-title">
    <div class="why-karate-section__inner">
        <div class="why-karate-section__heading">
            <p>Dlaczego karate?</p>
            <h2 id="why-karate-title">Więcej niż sport</h2>
        </div>

        <div class="why-karate-grid">
            <?php foreach ($whyKarateCards as $card): ?>
                <article class="why-karate-card">
                    <div class="why-karate-card__icon" aria-hidden="true">
                        <i class="<?= e($card['icon']) ?>"></i>
                    </div>

                    <div>
                        <h3><?= e($card['title']) ?></h3>
                        <p><?= e($card['description']) ?></p>
                    </div>
                </article>
            <?php endforeach ?>
        </div>
    </div>
</section>

<div class="padding-top">
        <?php foreach($legacyHomePosts as  $content): ?>
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
        <?php endforeach ?>
    </div>

<script src="/public/js/scroll.js"></script>
