<?php
$statusLegend = $statusLegend ?? 'Widoczność posta';
$enabledStatusTitle = $enabledStatusTitle ?? 'Publiczny';
$enabledStatusDescription = $enabledStatusDescription ?? 'Post jest widoczny na stronie.';
$disabledStatusTitle = $disabledStatusTitle ?? 'Niepubliczny';
$disabledStatusDescription = $disabledStatusDescription ?? 'Post jest ukryty na stronie.';
?>

<h3 class="dashboard-action-header"><?= e($formTitle ?? 'Szczegóły posta') ?></h3>

<div class="dashboard-action-page">
  <form class="dashboard-status-form" action="<?= e($action ?? '') ?>" method="POST">
    <input type="hidden" name="csrf_token" value="<?= e($csrf ?? '') ?>">
    <input type="hidden" name="postId" value="<?= e($data->id ?? '') ?>">

    <fieldset>
      <legend><?= e($statusLegend) ?></legend>
      <label>
        <input type="radio" name="postPublished" value="1" <?= (int) ($data->status ?? 0) === 1 ? 'checked' : '' ?>>
        <span><strong><?= e($enabledStatusTitle) ?></strong><small><?= e($enabledStatusDescription) ?></small></span>
      </label>
      <label>
        <input type="radio" name="postPublished" value="0" <?= (int) ($data->status ?? 0) === 0 ? 'checked' : '' ?>>
        <span><strong><?= e($disabledStatusTitle) ?></strong><small><?= e($disabledStatusDescription) ?></small></span>
      </label>

      <?php if (!empty($additionalFieldsHtml)): ?>
        <div class="dashboard-status-form__additional-fields">
          <?= $additionalFieldsHtml ?>
        </div>
      <?php endif; ?>
    </fieldset>

    <input type="submit" value="Zapisz">
  </form>

  <div class="post-content">
    <?= $postDetailsHtml ?? '' ?>
  </div>
</div>
