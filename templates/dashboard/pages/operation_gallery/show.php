<?php
$subpage = $params['page'] === 'news' ? 'aktualnosci' : $params['page'];
$actionUrl = "/?dashboard=start&subpage=galeria&operation=show&id=" . ($data['id'] ?? '');
?>

<br>
<h3>Szczegóły posta</h3>
<br>
<div class="post-content">
    <img class="dashboard-image" src="public/images/karate/<?= $data['image_name'] ?>" alt="">
	<p> <?= $data['description'] ?? "" ?> </p>
	<form action="<?= $actionUrl?>" method="POST">
		<input type="hidden" name="csrf_token" value="<?= $params['csrf_token'] ?? '' ?>">
		<input type="hidden" name="postId" value=" <?= $data['id'] ?? "" ?> ">
		<label>
			<input type="radio" name="postPublished" value='1' <?= $data['status'] == 1 ? 'checked' : '' ?>> Publiczny
		</label>
		<label>
			<input type="radio" name="postPublished" value='0' <?= $data['status'] == 0 ? 'checked' : '' ?>> Niepubliczny
		</label>
		<input type="submit" value="Zapisz">
	</form>
</div>