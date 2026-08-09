<?php
$cards = is_array($payload['cards'] ?? null) ? $payload['cards'] : [];
?>

<?php if (!empty($payload['eyebrow'])): ?>
    <p class="homepage-post-details__eyebrow"><?= e($payload['eyebrow']) ?></p>
<?php endif ?>

<h4><?= e($data->title ?? '') ?></h4>

<?php if (!empty($payload['description'])): ?>
    <p class="homepage-post-details__description"><?= nl2br(e($payload['description'])) ?></p>
<?php endif ?>

<?php if ($cards): ?>
    <div class="homepage-post-details__cards">
        <?php foreach ($cards as $card): ?>
            <?php if (is_array($card)): ?>
                <div class="homepage-post-details__card">
                    <?php if (!empty($card['icon'])): ?><i class="<?= e($card['icon']) ?>" aria-hidden="true"></i><?php endif ?>
                    <strong><?= e($card['title'] ?? '') ?></strong>
                    <p><?= e($card['description'] ?? '') ?></p>
                </div>
            <?php endif ?>
        <?php endforeach ?>
    </div>
<?php endif ?>
