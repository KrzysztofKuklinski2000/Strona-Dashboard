<?php 
$errors = $params['flash_dashboard']['message'] ?? [];
?>
<h3 class="dashboard-action-header">Dodawanie nowego subskrybenta</h3>
<form action="/dashboard/subscribers/store" method="POST" class="subscriber-form dashboard-editor-form">
  <input type="hidden" name="csrf_token" value="<?= e($params['csrf_token'] ?? '') ?>">

  <section class="dashboard-form-section">
    <header class="dashboard-form-section__header">
      <span class="dashboard-form-section__icon"><i class="fa-regular fa-envelope" aria-hidden="true"></i></span>
      <span class="dashboard-form-section__title">
        <strong>Dane subskrybenta</strong>
        <small>Dodaj adres e-mail do listy odbiorców powiadomień.</small>
      </span>
    </header>

    <label>
      <span>Adres e-mail</span>
      <input type="email" name="email" maxlength="100" placeholder="np. odbiorca@example.pl">
    </label>
    <p class="validation-error"><?= e($errors['email'] ?? '') ?></p>
  </section>

  <div class="dashboard-form-actions">
    <span>Nowy adres zostanie dodany do listy subskrybentów.</span>
    <input type="submit" value="Dodaj">
  </div>
</form>
