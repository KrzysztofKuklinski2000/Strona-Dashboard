<?php
$numberOfRows = (int) ($params['numberOfRows'] ?? 1);
$currentPage = (int) ($params['currentNumberOfPage'] ?? 1);
$newsPosts = array_values(array_filter(
    $params['content'] ?? [],
    static fn($post): bool => (bool) ($post->status ?? false)
));
?>

<section class="news-page" aria-labelledby="news-page-title">
    <div class="news-page__inner">
        <div class="news-page__heading">
            <p>Aktualności</p>
            <h2 id="news-page-title">Co nowego w klubie?</h2>
        </div>

        <?php if ($newsPosts): ?>
            <div class="news-page__grid">
                <?php foreach ($newsPosts as $index => $content): ?>
                    <?php
                    $createdTimestamp = strtotime($content->created ?? '');
                    $createdDate = $createdTimestamp ? date('d.m.Y', $createdTimestamp) : '';
                    $createdDateTime = $createdTimestamp ? date('Y-m-d', $createdTimestamp) : '';
                    $imageName = $content->imageName ?? $content->image_name ?? null;
                    ?>

                    <article class="news-card <?= $index === 0 ? 'news-card--featured' : '' ?>">
                        <?php if ($imageName): ?>
                            <div class="news-card__media">
                                <img src="/public/uploads/<?= rawurlencode((string) $imageName) ?>" alt="<?= e($content->title) ?>" loading="lazy">
                            </div>
                        <?php else: ?>
                            <div class="news-card__media news-card__media--fallback" aria-hidden="true">
                                <i class="fa-regular fa-newspaper"></i>
                            </div>
                        <?php endif ?>

                        <div class="news-card__content">
                            <?php if ($createdDate): ?>
                                <time datetime="<?= e($createdDateTime) ?>"><?= e($createdDate) ?></time>
                            <?php endif ?>

                            <h3><?= e($content->title) ?></h3>
                            <p><?= e_br($content->description) ?></p>
                        </div>
                    </article>
                <?php endforeach ?>
            </div>
        <?php else: ?>
            <div class="news-page__empty">
                <i class="fa-regular fa-newspaper" aria-hidden="true"></i>
                <h2>Brak aktualności</h2>
                <p>Aktualne informacje klubowe pojawią się w tym miejscu po publikacji.</p>
            </div>
        <?php endif ?>

        <?php if ($numberOfRows > 1): ?>
            <nav class="news-pagination" aria-label="Paginacja aktualności">
                <?php if ($currentPage > 1): ?>
                    <a class="news-pagination__arrow" href="/aktualnosci/<?= $currentPage - 1 ?>" aria-label="Poprzednia strona">
                        <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                    </a>
                <?php endif ?>

                <?php for ($i = 1; $i <= $numberOfRows; $i++): ?>
                    <a class="<?= $i === $currentPage ? 'is-active' : '' ?>" href="/aktualnosci/<?= $i ?>">
                        <?= $i ?>
                    </a>
                <?php endfor ?>

                <?php if ($currentPage < $numberOfRows): ?>
                    <a class="news-pagination__arrow" href="/aktualnosci/<?= $currentPage + 1 ?>" aria-label="Następna strona">
                        <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    </a>
                <?php endif ?>
            </nav>
        <?php endif ?>
    </div>
</section>
