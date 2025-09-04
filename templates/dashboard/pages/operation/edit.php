
<?php
	$subpage = $params['page'] === 'news' ? 'aktualnosci' : $params['page'];
	$actionUrl = "/?dashboard=start&subpage=$subpage&operation=edit&id=" . ($data['id'] ?? '');
?>

<br>
<h3>Edytuj </h3>
<br>
<form action="<?= $actionUrl ?>" method="POST">
	<input type="hidden" name="csrf_token" value="<?php echo $params['csrf_token'] ?? '' ?>">
	<input type="hidden" name="postId" value="<?php echo $data['id'] ?? "" ?>">
	<input type="text" name="postTitle" maxlength="60" minlength="10" placeholder="Tytuł posta" value="<?php echo $data['title'] ?? "" ?>">
	<p class="validation-error"><?= $params['flash']['message']['postTitle'] ?? ""  ?></p>
	<textarea name="postDescription" maxlength="1000" minlength="20" placeholder="Wpisz treść posta"> <?php echo $data['description'] ?? "" ?></textarea>
	<p class="validation-error"><?= $params['flash']['message']['postDescription'] ?? ""  ?></p>
	<input type="submit" value="Zapisz">
</form>