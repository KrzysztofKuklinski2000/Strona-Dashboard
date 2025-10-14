<br>
<h3><?= $formTitle ?? "Usuń post" ?></h3>
<br>
<?= $postDetailsHtml ?? '' ?>
<form action="<?= $action ?>" method="POST">
  <input type="hidden" name="csrf_token" value="<?= $csrf ?? "" ?>">
  <input type="hidden" name="postId" value="<?= $data['id'] ?? "" ?>">
  <input type="submit" value="Usuń"> 
</form>