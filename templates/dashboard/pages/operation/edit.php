<br>
<h3>Edytuj </h3>
<br>
<form action="?dashboard=start&subpage=<?php echo $params['page'] == 'news' ? 'aktualnosci' : $params['page'] ?>&operation=edit" method="POST">
	<input type="hidden" name="postId" value="<?php echo $data['id'] ?>" >
	<input type="text" name="postTitle" maxlength="40" placeholder="Tytuł posta" value = "<?php echo $data['title'] ?>">
	<textarea name="postDescription" maxlength="200" placeholder="Wpisz treść posta"> <?php echo $data['description'] ?> </textarea>
	<input type="submit" value="Zapisz">
</form>