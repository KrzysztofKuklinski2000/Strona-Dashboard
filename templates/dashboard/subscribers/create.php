<?php 
$errors = $params['flash_dashboard']['message'] ?? [];
?>
<h3 class="dashboard-action-header">Dodawanie nowego subskrybenta</h3>
<form action="/dashboard/subscribers/store" method="POST">
	<input type="hidden" name="csrf_token" value="<?= e($params['csrf_token'] ?? '') ?>">

	<input type="email" name="email" maxlength="100" placeholder="Email">
    <p class="validation-error"><?= e($errors['email'] ?? '') ?></p>
	<input type="submit" value="Dodaj">
</form>
