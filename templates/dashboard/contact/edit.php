<?php 
$data = $params['data'];
$csrf = $params['csrf_token'] ?? '';
$errors = $params['flash']['message'] ?? [];
?>

<div class="list-header">
  <h3>Kontakt - Edytuj</h3>
</div>
<br>
<form action="/?dashboard=contact&action=update" method="POST" class="contact-form">
  <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
  <label>
    <span>E-mail:</span>
    <input type="email" name="email" value="<?= $data['email'] ?>">
  </label>
  <p class="validation-error"><?= $errors['email'] ?? ""  ?></p>
  <label>
    <span>Telefon: </span>
    <input type="tel" name="phone" value="<?= $data['phone'] ?>">
  </label>
  <p class="validation-error"><?= $errors['phone'] ?? ""  ?></p>
  <label>
    <span>Adres: </span>
    <input type="text" name="address" value="<?= $data['address'] ?>">
  </label>
  <p class="validation-error"><?= $errors['address'] ?? ""  ?></p>
  <input type="submit" value="Zapisz">
</form>