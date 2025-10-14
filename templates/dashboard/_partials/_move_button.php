<form action="<?= $action ?>" method="POST">
  <input type="hidden" name="csrf_token" value="<?= $csrf ?? '' ?>">
  <input type="hidden" name="id" value="<?= $postId ?? '' ?>">
  <input type="hidden" name="dir" value="<?= $direction ?? '' ?>">
  <button type="submit">
    <i class="fa-solid fa-caret-<?= $direction ?>"></i>
  </button>
</form>