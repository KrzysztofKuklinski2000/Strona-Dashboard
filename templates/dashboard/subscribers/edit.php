<?php
$data = $params['data'];
$csrf = $params['csrf_token'] ?? '';
$action = "/dashboard/subscribers/update/" . ($data->id ?? '');
$errors = $params['flash_dashboard']['message'] ?? [];
?>

<h3 class="dashboard-action-header">Edytowanie adresu e-mail subskrybenta</h3>
<form action="<?= e($action ?? "") ?>" method="POST">
  <input type="hidden" name="csrf_token" value="<?= e($csrf ?? '') ?>">

  <?php if (isset($data->id)): ?>
    <input type="hidden" name="id" value="<?= e($data->id ?? "") ?>">
  <?php endif; ?>

  <input type="email" name="email" maxlength="100" value="<?= e($data->email ?? "") ?>" placeholder="Podaj email">
  <p class="validation-error"><?= e($errors['email'] ?? "")  ?></p>

  <label>
    <input type="checkbox" name="is_active" value="1" <?= ( $data->isActive ?? 0 ) ? 'checked' : '' ?> >
    Subskrypcja aktywna
  </label>
  <input type="submit" value="Zapisz">
</form>
