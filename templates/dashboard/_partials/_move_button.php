<?php $moveLabel = $direction === 'up' ? 'Przenieś wyżej' : 'Przenieś niżej'; ?>
<form class="dashboard-position-form" action="<?= e($action) ?>" method="POST">
  <input type="hidden" name="csrf_token" value="<?= e($csrf ?? '') ?>">
  <input type="hidden" name="id" value="<?= e($postId ?? '') ?>">
  <input type="hidden" name="dir" value="<?= e($direction ?? '') ?>">
  <button class="dashboard-position-button" type="submit" aria-label="<?= e($moveLabel) ?>" title="<?= e($moveLabel) ?>">
    <i class="fa-solid fa-caret-<?= e($direction) ?>" aria-hidden="true"></i>
  </button>
</form>
