<?php
$subpage = $params['page'] === 'news' ? 'aktualnosci' : $params['page'];
$actionUrl = "/?dashboard=start&subpage=$subpage&operation=delete&id=" . ($data['id'] ?? '');
?>
<br>
<h3>Usuń post</h3>
<br>
<h4>Tytuł posta: <?php echo $data['title'] ?? "" ?> </h4>
<form action="<?= $actionUrl ?>" method="POST">
	<input type="hidden" name="postId" value="<?php echo $data['id'] ?? "" ?>">
	<input type="submit" value="Usuń">
</form>