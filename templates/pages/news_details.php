<?php

use App\Content\NewsPostTypes;

$post = $params['content'];
$detailsPartial = (string) ($params['detailsPartial'] ?? '');
$detailsPartialPath = __DIR__ . '/news_details/' . $detailsPartial;
$payload = json_decode((string) ($post->payload ?? ''), true);
$payload = is_array($payload) ? $payload : [];
$typeDetails = NewsPostTypes::get((string) ($post->type ?? ''));
$typeLabel = (string) ($typeDetails['label'] ?? 'Aktualność');
?>

<section class="news-details-page" aria-label="Szczegóły aktualności">
    <div class="news-details-page__inner">
        <div class="news-details-page__toolbar">
            <a class="news-details-page__back" href="/aktualnosci">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                Wszystkie aktualności
            </a>

            <div class="news-details-page__meta">
                <span><?= e($typeLabel) ?></span>
            </div>
        </div>

        <article class="news-details-page__article">
            <?php require $detailsPartialPath ?>
        </article>
    </div>
</section>
