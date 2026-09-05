<?php
use App\Content\NewsPostTypes;

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
                    $payload = json_decode((string) ($content->payload ?? ''), true);
                    $payload = is_array($payload) ? $payload : [];
                    $type = (string) ($content->type ?? NewsPostTypes::ARTICLE);

                    if (!NewsPostTypes::isAllowed($type)) {
                        $type = NewsPostTypes::ARTICLE;
                    }

                    $partial = NewsPostTypes::partial($type)
                        ?? NewsPostTypes::partial(NewsPostTypes::ARTICLE);

                    if ($partial !== null) {
                        require __DIR__ . '/news_posts/' . $partial;
                    }
                    ?>
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
