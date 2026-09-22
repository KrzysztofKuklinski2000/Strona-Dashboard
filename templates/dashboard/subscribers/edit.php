<?php
$data = $params['data'];
$csrf = $params['csrf_token'] ?? '';
$action = "/dashboard/subscribers/update/" . ($data->id ?? '');
$errors = $params['flash_dashboard']['message'] ?? [];
?>

<h3 class="dashboard-action-header">Edytowanie adresu e-mail subskrybenta</h3>
<form action="<?= e($action ?? '') ?>" method="POST" class="subscriber-form dashboard-editor-form">
  <input type="hidden" name="csrf_token" value="<?= e($csrf ?? '') ?>">

  <?php if (isset($data->id)): ?>
    <input type="hidden" name="id" value="<?= e($data->id ?? "") ?>">
  <?php endif; ?>

  <section class="dashboard-form-section">
    <header class="dashboard-form-section__header">
      <span class="dashboard-form-section__icon"><i class="fa-regular fa-envelope" aria-hidden="true"></i></span>
      <span class="dashboard-form-section__title">
        <strong>Dane subskrybenta</strong>
        <small>Zmień adres e-mail lub status subskrypcji.</small>
      </span>
    </header>

    <label>
      <span>Adres e-mail</span>
      <input type="email" name="email" maxlength="100" value="<?= e($data->email ?? '') ?>" placeholder="np. odbiorca@example.pl">
    </label>
    <p class="validation-error"><?= e($errors['email'] ?? '') ?></p>

    <label class="dashboard-form-check">
      <input type="checkbox" name="is_active" value="1" <?= ($data->isActive ?? 0) ? 'checked' : '' ?>>
      <span>
        <strong>Subskrypcja aktywna</strong>
        <small>Aktywny subskrybent może otrzymywać wysyłane powiadomienia.</small>
      </span>
    </label>
  </section>

  <div class="dashboard-form-actions">
    <span>Zapisz zmiany adresu lub statusu subskrypcji.</span>
    <input type="submit" value="Zapisz">
  </div>
</form>
