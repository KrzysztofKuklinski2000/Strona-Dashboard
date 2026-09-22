<?php 
$data = $params['data'];
$csrf = $params['csrf_token'] ?? '';
$errors = $params['flash_dashboard']['message'] ?? [];
?>

<h3 class="dashboard-action-header">Edycja danych kontaktowych</h3>

<form action="/dashboard/contact/update" method="POST" class="contact-form dashboard-editor-form">
  <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">

  <section class="dashboard-form-section">
    <header class="dashboard-form-section__header">
      <span class="dashboard-form-section__icon"><i class="fa-regular fa-address-book" aria-hidden="true"></i></span>
      <span class="dashboard-form-section__title">
        <strong>Dane kontaktowe</strong>
        <small>Informacje wyświetlane użytkownikom na stronie kontaktowej.</small>
      </span>
    </header>

    <div class="dashboard-form-grid dashboard-form-grid--three">
      <label>
        <span>E-mail</span>
        <input type="email" name="email" value="<?= e($data->email) ?>" placeholder="np. kontakt@example.pl">
      </label>
      <p class="validation-error"><?= e($errors['email'] ?? '') ?></p>

      <label>
        <span>Telefon</span>
        <input type="tel" name="phone" value="<?= e($data->phone) ?>" placeholder="np. 500 000 000">
      </label>
      <p class="validation-error"><?= e($errors['phone'] ?? '') ?></p>

      <label>
        <span>Adres</span>
        <input type="text" name="address" value="<?= e($data->address) ?>" placeholder="Ulica, kod pocztowy i miejscowość">
      </label>
      <p class="validation-error"><?= e($errors['address'] ?? '') ?></p>
    </div>
  </section>

  <div class="dashboard-form-actions">
    <span>Zmiany będą widoczne na publicznej stronie po zapisaniu.</span>
    <input type="submit" value="Zapisz">
  </div>
</form>
