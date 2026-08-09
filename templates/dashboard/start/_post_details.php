<?php

use App\Content\MainPagePostTypes;

$payload = json_decode((string) ($data->payload ?? ''), true);
$payload = is_array($payload) ? $payload : [];
$type = (string) ($data->type ?? MainPagePostTypes::SIMPLE_TEXT);
$typeProperties = MainPagePostTypes::get($type);
$typeLabel = (string) ($typeProperties['label'] ?? $type);
$detailsPartial = MainPagePostTypes::partial($type)
    ?? MainPagePostTypes::partial(MainPagePostTypes::SIMPLE_TEXT);
$detailsPartialPath = $detailsPartial === null
    ? null
    : 'templates/dashboard/start/post_details/' . $detailsPartial;
?>

<article class="homepage-post-details">
    <dl class="homepage-post-details__meta">
        <div><dt>Typ posta</dt><dd><?= e($typeLabel) ?></dd></div>
        <div><dt>Status</dt><dd class="<?= (int) ($data->status ?? 0) === 1 ? 'is-public' : 'is-private' ?>"><?= (int) ($data->status ?? 0) === 1 ? 'Publiczny' : 'Niepubliczny' ?></dd></div>
        <div><dt>Pozycja</dt><dd><?= e($data->position ?? '—') ?></dd></div>
        <div><dt>Aktualizacja</dt><dd><?= e($data->updated ?? '—') ?></dd></div>
    </dl>

    <section class="homepage-post-details__content">
        <?php if ($detailsPartialPath !== null): ?>
            <?php require $detailsPartialPath; ?>
        <?php endif ?>
    </section>
</article>
