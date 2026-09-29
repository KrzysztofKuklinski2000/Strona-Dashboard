<?php

use App\Content\NewsPostTypes;

$content = $data;
$payload = json_decode((string) ($content->payload ?? ''), true);
$payload = is_array($payload) ? $payload : [];
$detailsUrl = '/aktualnosci/wpis/' . (int) ($content->id ?? 0);
$type = (string) ($content->type ?? NewsPostTypes::ARTICLE);
$index = 0;

if (!NewsPostTypes::isAllowed($type)) {
    $type = NewsPostTypes::ARTICLE;
}

$partial = NewsPostTypes::partial($type)
    ?? NewsPostTypes::partial(NewsPostTypes::ARTICLE);

ob_start();
?>
<section class="news-page">
    <div class="news-page__inner">
        <div class="news-page__grid">
            <?php if ($partial !== null): ?>
                <?php require 'templates/pages/news_posts/' . $partial; ?>
            <?php endif ?>
        </div>
    </div>
</section>
<?php
$previewHtml = ob_get_clean();
$previewTitle = 'Podgląd wpisu na podstronie Aktualności';
$previewDescription = 'Tak wpis będzie prezentowany na liście aktualności.';
$previewBodyClass = '';

require 'templates/dashboard/_partials/_public_post_preview.php';
