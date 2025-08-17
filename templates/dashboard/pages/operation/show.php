<br>
<h3>Szczegóły posta</h3>
<br>

<div class="post-content">
	<h4>Tytuł: <?php echo $data['title'] ?? "" ?> </h4>
	<p> <?php echo $data['description'] ?? "" ?> </p>
	<form action="?dashboard=start&subpage=<?php echo $params['page'] == 'news' ? 'aktualnosci' : $params['page'] ?>&operation=show" method="POST">
		<input type="hidden" name="postId" value=" <?php echo $data['id'] ?? "" ?> ">
		<label>
			<input type="radio" name="postPublished" value='1' <?php echo $data['status'] ?? "" == 1 ? 'checked' : '' ?>> Publiczny
		</label>
		<label>
			<input type="radio" name="postPublished" value='0' <?php echo $data['status'] ?? "" == 0 ? 'checked' : '' ?> > Niepubliczny
		</label>
		<input type="submit" value="Zapisz">
	</form>	
</div>