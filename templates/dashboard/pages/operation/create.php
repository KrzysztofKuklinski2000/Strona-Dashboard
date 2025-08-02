
<br>
<h3>Nowy Post </h3>
<br>
<form action="?dashboard=start&subpage=<?php echo $params['page'] == 'news' ? 'aktualnosci' : $params['page'] ?>&operation=create" method="POST">
	<input type="text" name="postTitle" maxlength="100" placeholder="Tytuł posta">
	<textarea name="postDescription" placeholder="Wpisz treść posta"></textarea>
	<input type="submit" value="Stwórz">
</form>