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

<div class="padding-top">
    <?php if($first): ?>
        <div class="post-free">
            <div class="post">
                <div class="left-side-post">
                    <?php 
                        $text = $first->title;
                        require('templates/components/post_header.php'); 
                    ?>
                </div>
                <div class="post-content flex-item-center">
                    <span>zajęcia za darmo</span>
                    <p><?= e_br($first->description) ?></p><br/>
                    <a class="text-uppercase" href="/zapisy">Zapisz się</a>
                </div>
            </div>
        </div>
    <?php endif ?>
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
