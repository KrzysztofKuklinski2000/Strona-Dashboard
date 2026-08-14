<?php if (!empty($payload['eyebrow'])): ?>
    <p class="homepage-post-details__eyebrow"><?= e($payload['eyebrow']) ?></p>
<?php endif ?>

<h4><?= e($data->title ?? '') ?></h4>

<?php if (!empty($payload['description'])): ?>
    <p class="homepage-post-details__description"><?= nl2br(e($payload['description'])) ?></p>
<?php endif ?>
