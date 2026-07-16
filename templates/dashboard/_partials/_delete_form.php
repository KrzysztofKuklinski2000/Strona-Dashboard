<h3 class="dashboard-action-header"><?= e($formTitle ?? 'Usuń post') ?></h3>

<div class="dashboard-action-page">
  <div class="dashboard-delete-warning">
    <i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i>
    <div>
      <strong>Czy na pewno chcesz usunąć ten wpis?</strong>
      <p>Tej operacji nie można cofnąć.</p>
    </div>
  </div>

  <div class="post-content">
    <?= $postDetailsHtml ?? '' ?>
  </div>

  <form class="dashboard-delete-form" action="<?= e($action ?? '') ?>" method="POST">
    <input type="hidden" name="csrf_token" value="<?= e($csrf ?? '') ?>">
    <input type="hidden" name="postId" value="<?= e($data->id ?? '') ?>">
    <input type="submit" value="Usuń">
  </form>
</div>
