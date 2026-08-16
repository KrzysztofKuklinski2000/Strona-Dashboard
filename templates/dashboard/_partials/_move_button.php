<form action="<?= e($action) ?>" method="POST">
  <input type="hidden" name="csrf_token" value="<?= e($csrf ?? '') ?>">
  <input type="hidden" name="id" value="<?= e($postId ?? '') ?>">
  <input type="hidden" name="dir" value="<?= e($direction ?? '') ?>">
  <button type="submit">
    <i class="fa-solid fa-caret-<?= e($direction) ?>"></i>
  </button>
</form>