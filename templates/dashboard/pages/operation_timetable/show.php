<br>
<h3>Szczegóły posta</h3>
<br>

<div class="post-content">
	<h4>Dzień: <?php echo $data['day'] ?></h4>
	<h4>Miasto: <?php echo $data['city'] ?></h4>
	<h4>Grupa: <?php echo $data['advancement_group'] ?></h4>
	<h4>Szczegóły: <?php echo $data['place'] ?></h4>
	<h4>Start: <?php echo $data['start'] ?></h4>
	<h4>Koniec: <?php echo $data['end'] ?></h4>

	<form action="?dashboard=start&subpage=grafik&operation=show" method="POST">
		<input type="hidden" name="postId" value="<?php echo $data['id'] ?>">
		<label>
			<input type="radio" name="postPublished" value="1" <?php echo $data['status'] == 1 ? 'checked' : '' ?>> Publiczny
		</label>
		<label>
			<input type="radio" name="postPublished" value="0" <?php echo $data['status'] == 0 ? 'checked' : '' ?>> Niepubliczny
		</label>
		<input type="submit" value="Zapisz">
	</form>
</div>