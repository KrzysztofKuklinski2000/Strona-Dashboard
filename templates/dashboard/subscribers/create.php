<?php 
$errors = $params['flash']['message'] ?? [];
?>
<br>
<h3>Dodaj nowego użytkownika</h3>
<br>
<form action="/dashboard/subscribers/store" method="POST">
	<input type="hidden" name="csrf_token" value="<?= $params['csrf_token'] ?? '' ?>">

	<input type="email" name="email" maxlength="100" value="<?= $data['email'] ?? "" ?>" placeholder="Email">
  	<p class="validation-error"><?= $errors['email'] ?? ""  ?></p>

	<input type="submit" value="Dodaj">
</form>
