<?php
$data = $params['data'];
$csrf = $params['csrf_token'] ?? '';
$action = "/dashboard/subscribers/update/" . ($data['id'] ?? '');
$errors = $params['flash_dashboard']['message'] ?? [];
?>

<br>
<h3>Edytuj email subskrybenta</h3>
<br>
<form action="<?= $action ?? "" ?>" method="POST">
  <input type="hidden" name="csrf_token" value="<?= $csrf ?? '' ?>">

  <?php if (isset($data['id'])): ?>
    <input type="hidden" name="id" value="<?= $data['id'] ?? "" ?>">
  <?php endif; ?>

  <input type="email" name="email" maxlength="100" value="<?= $data['email'] ?? "" ?>" placeholder="Podaj email">
  <p class="validation-error"><?= $errors['email'] ?? ""  ?></p>

  <label>
    <input type="checkbox" name="is_active" value="1" <?= ( $data['is_active'] ?? 0 ) ? 'checked' : '' ?> >
    Subskrypcja aktywna
  </label>
 
  <input type="submit" value="Zapisz">
</form>