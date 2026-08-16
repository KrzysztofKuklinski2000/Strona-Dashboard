<?php 
$data = $params['data'];
$csrf = $params['csrf_token'] ?? '';
$errors = $params['flash_dashboard']['message'] ?? [];
?>

<div class="list-header">
  <h3>Kontakt - Edytuj</h3>
</div>
<br>
<form action="/dashboard/contact/update" method="POST" class="contact-form">
  <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
  <label>
    <span>E-mail:</span>
    <input type="email" name="email" value="<?= e($data->email) ?>">
  </label>
  <p class="validation-error"><?= e($errors['email'] ?? "")  ?></p>
  <label>
    <span>Telefon: </span>
    <input type="tel" name="phone" value="<?= e($data->phone) ?>">
  </label>
  <p class="validation-error"><?= e($errors['phone'] ?? "")  ?></p>
  <label>
    <span>Adres: </span>
    <input type="text" name="address" value="<?= e($data->address) ?>">
  </label>
  <p class="validation-error"><?= e($errors['address'] ?? "")  ?></p>
  <input type="submit" value="Zapisz">
</form>