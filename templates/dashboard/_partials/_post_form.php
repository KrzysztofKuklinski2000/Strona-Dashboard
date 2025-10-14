<br>
<h3><?= $formTitle ?? "Nowy Post" ?></h3>
<br>
<form action="<?= $action ?? "" ?>" method="POST">
  <input type="hidden" name="csrf_token" value="<?= $csrf ?? '' ?>">

  <?php if (isset($data['id'])): ?>
    <input type="hidden" name="postId" value="<?= $data['id'] ?? "" ?>">
  <?php endif; ?>

  <input type="text" name="postTitle" maxlength="100" value="<?= $data['title'] ?? "" ?>" placeholder="Tytuł posta">
  <p class="validation-error"><?= $errors['postTitle'] ?? ""  ?></p>

  <textarea name="postDescription" placeholder="Wpisz treść posta">
    <?= $data['description'] ?? "" ?>
  </textarea>
  <p class="validation-error"><?= $errors['postDescription'] ?? ""  ?></p>

  <!-- Dodatkowe pola formularza -->
  <?php
  if (isset($extraFieldsHtml) && is_string($extraFieldsHtml)) {
    echo $extraFieldsHtml;
  }
  ?>

  <input type="submit" value="<?= $buttonTitle ?? "Stwórz" ?>">
</form>