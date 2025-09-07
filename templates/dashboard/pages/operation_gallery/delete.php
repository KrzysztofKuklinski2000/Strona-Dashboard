<?php 
$actionUrl = "/?dashboard=start&subpage=galeria&operation=delete&id=" . ($data['id'] ?? '');
?>

<br>
<h3>Usuń Zdjęcie</h3>
<br>
<img class="dashboard-image" src="public/images/karate/<?= $data['image_name'] ?>" alt="">
<h4>Opis: <?= $data['description'] ?></h4>
<h4>Data Utworzenia: <?= $data['created_at'] ?></h4>
<form action="<?= $actionUrl ?>" method="Post">
	<input type="hidden" name="csrf_token" value="<?= $params['csrf_token'] ?? '' ?>">
	<input type="hidden" name="postId" value="<?= $data['id'] ?>">
	<input type="submit" value="Usuń">
</form>