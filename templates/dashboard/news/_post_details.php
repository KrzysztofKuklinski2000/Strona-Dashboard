<?php

use App\Content\NewsPostTypes;

$type = (string) ($data->type ?? NewsPostTypes::ARTICLE);

if (!NewsPostTypes::isAllowed($type)) {
    $type = NewsPostTypes::ARTICLE;
}

$typeProperties = NewsPostTypes::get($type);
$typeLabel = (string) ($typeProperties['label'] ?? $type);
?>

<article class="homepage-post-details news-post-details">
    <dl class="homepage-post-details__meta">
        <div><dt>Typ aktualności</dt><dd><?= e($typeLabel) ?></dd></div>
        <div><dt>Status</dt><dd class="<?= (int) ($data->status ?? 0) === 1 ? 'is-public' : 'is-private' ?>"><?= (int) ($data->status ?? 0) === 1 ? 'Publiczny' : 'Niepubliczny' ?></dd></div>
        <div><dt>Pozycja</dt><dd><?= e($data->position ?? '—') ?></dd></div>
        <div><dt>Aktualizacja</dt><dd><?= e($data->updated ?? '—') ?></dd></div>
    </dl>

    <section class="homepage-post-details__content">
        <?php require 'templates/dashboard/news/_post_preview.php'; ?>
    </section>
</article>
