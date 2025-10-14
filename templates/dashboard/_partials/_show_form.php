<br>
<h3><?= $formTitle ?? "Szczegóły posta" ?></h3>
<br>
<div class="post-content">
<?= $postDetailsHtml ?? '' ?>
</div>
  <form action="<?= $action ?>" method="POST">
    <input type="hidden" name="csrf_token" value="<?= $csrf ?? '' ?>">
    <input type="hidden" name="postId" value=" <?= $data['id'] ?? "" ?> ">
    <label>
      <input type="radio" name="postPublished" value='1' <?= $data['status'] == 1 ? 'checked' : '' ?>> Publiczny
    </label>
    <label>
      <input type="radio" name="postPublished" value='0' <?= $data['status'] == 0 ? 'checked' : '' ?>> Niepubliczny
    </label>
    <input type="submit" value="Zapisz">
  </form>
</div>