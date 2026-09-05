<?php
$description = $payload['description'] ?? '';
?>

<h4><?= e($data->title ?? '') ?></h4>

<?php if ($description !== ''): ?>
    <p class="homepage-post-details__description"><?= e_br($description) ?></p>
<?php endif ?>
