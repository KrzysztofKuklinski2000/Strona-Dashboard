<h3 class="dashboard-action-header"><?= e($formTitle ?? 'Szczegóły posta') ?></h3>

<div class="dashboard-action-page">
  <div class="post-content">
    <?= $postDetailsHtml ?? '' ?>
  </div>

  <form class="dashboard-status-form" action="<?= e($action ?? '') ?>" method="POST">
    <input type="hidden" name="csrf_token" value="<?= e($csrf ?? '') ?>">
    <input type="hidden" name="postId" value="<?= e($data->id ?? '') ?>">

    <fieldset>
      <legend>Widoczność posta</legend>
      <label>
        <input type="radio" name="postPublished" value="1" <?= (int) ($data->status ?? 0) === 1 ? 'checked' : '' ?>>
        <span><strong>Publiczny</strong><small>Post jest widoczny na stronie.</small></span>
      </label>
      <label>
        <input type="radio" name="postPublished" value="0" <?= (int) ($data->status ?? 0) === 0 ? 'checked' : '' ?>>
        <span><strong>Niepubliczny</strong><small>Post jest ukryty na stronie.</small></span>
      </label>
    </fieldset>

    <input type="submit" value="Zapisz">
  </form>
</div>
