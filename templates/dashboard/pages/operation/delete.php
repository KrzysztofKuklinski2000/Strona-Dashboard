<br>
<h3>Usuń post</h3>
<br>
<h4>Tytuł posta: <?php echo $data['title'] ?? "" ?> </h4>
<form action="?dashboard=start&subpage=<?php echo $params['page'] == 'news' ? 'aktualnosci' : $params['page'] ?>&operation=delete" method="Post">
	<input type="hidden" name="postId" value="<?php echo $data['id'] ?? "" ?>">
	<input type="submit" value="Usuń">
</form>