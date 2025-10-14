<br>
<h3>Nowe Zdjęcie do galerii</h3>
<br>
<form action="?dashboard=gallery&action=store" method="POST" enctype="multipart/form-data" class="timetable-create-form">
	<input type="hidden" name="csrf_token" value="<?= $params['csrf_token'] ?? '' ?>">
	<label>
		<span>Kategoria: </span>
		<select name="category">
			<option value="training">Trening</option>
			<option value="camp">Obóz</option>
		</select>
	</label>
	<p class="validation-error"><?= $params['flash']['message']['category'] ?? ""  ?></p>
	<label>
		<span>Opis: </span>
		<input type="text" name="description" maxlength="50" placeholder="Opis...">
	</label>
	<p class="validation-error"><?= $params['flash']['message']['description'] ?? ""  ?></p>
	<label>
		<span>Zdjęcie:</span>
		<input type="file" name="image_name">
	</label>
	<p class="validation-error"><?= $params['flash']['message']['image_name'] ?? ""  ?></p>
	<input type="submit" value="Stwórz">
</form>