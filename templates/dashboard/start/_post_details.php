<?php
$payload = json_decode((string) ($data->payload ?? ''), true);
$payload = is_array($payload) ? $payload : [];
$type = (string) ($data->type ?? 'simple_text');
$detailItems = array_values(array_filter(
    is_array($payload['items'] ?? null) ? $payload['items'] : [],
    static fn(mixed $item): bool => is_scalar($item) && trim((string) $item) !== '',
));
$hasDetailLink = !empty($payload['link']['label']) && !empty($payload['link']['url']);
$typeLabels = [
    'simple_text' => 'Prosty tekst',
    'cards_grid' => 'Kafelki',
    'image_text_list' => 'Obrazek + tekst',
];
?>

<article class="homepage-post-details">
    <dl class="homepage-post-details__meta">
        <div><dt>Typ posta</dt><dd><?= e($typeLabels[$type] ?? $type) ?></dd></div>
        <div><dt>Status</dt><dd class="<?= (int) ($data->status ?? 0) === 1 ? 'is-public' : 'is-private' ?>"><?= (int) ($data->status ?? 0) === 1 ? 'Publiczny' : 'Niepubliczny' ?></dd></div>
        <div><dt>Pozycja</dt><dd><?= e($data->position ?? '—') ?></dd></div>
        <div><dt>Aktualizacja</dt><dd><?= e($data->updated ?? '—') ?></dd></div>
    </dl>

    <section class="homepage-post-details__content">
        <?php if (!empty($payload['eyebrow'])): ?>
            <p class="homepage-post-details__eyebrow"><?= e($payload['eyebrow']) ?></p>
        <?php endif ?>

        <h4><?= e($data->title ?? '') ?></h4>

        <?php if (!empty($data->description)): ?>
            <p class="homepage-post-details__description"><?= nl2br(e($data->description)) ?></p>
        <?php endif ?>

        <?php if ($type === 'cards_grid' && !empty($payload['cards'])): ?>
            <div class="homepage-post-details__cards">
                <?php foreach ($payload['cards'] as $card): ?>
                    <div class="homepage-post-details__card">
                        <?php if (!empty($card['icon'])): ?><i class="<?= e($card['icon']) ?>" aria-hidden="true"></i><?php endif ?>
                        <strong><?= e($card['title'] ?? '') ?></strong>
                        <p><?= e($card['description'] ?? '') ?></p>
                    </div>
                <?php endforeach ?>
            </div>
        <?php elseif ($type === 'image_text_list'): ?>
            <div class="homepage-post-details__image-list <?= !$detailItems && !$hasDetailLink ? 'is-image-only' : '' ?>">
                <div class="homepage-post-details__image">
                    <?php if (!empty($payload['image']['src'])): ?>
                        <img src="<?= e($payload['image']['src']) ?>" alt="<?= e($payload['image']['alt'] ?? '') ?>">
                    <?php else: ?>
                        <i class="fa-regular fa-image" aria-hidden="true"></i>
                        <span>Brak obrazu</span>
                    <?php endif ?>
                </div>

                <?php if ($detailItems || $hasDetailLink): ?>
                    <div>
                    <?php if ($detailItems): ?>
                        <ul>
                            <?php foreach ($detailItems as $item): ?>
                                <li><i class="fa-solid fa-check" aria-hidden="true"></i><?= e($item) ?></li>
                            <?php endforeach ?>
                        </ul>
                    <?php endif ?>

                    <?php if ($hasDetailLink): ?>
                        <p class="homepage-post-details__link"><i class="fa-solid fa-link" aria-hidden="true"></i><?= e($payload['link']['label']) ?> — <?= e($payload['link']['url'] ?? '') ?></p>
                    <?php endif ?>
                    </div>
                <?php endif ?>
            </div>
        <?php endif ?>
    </section>
</article>
