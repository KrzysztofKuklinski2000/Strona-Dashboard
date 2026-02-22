<?php
	$data = $params['data'];
	$action = "/dashboard/gallery/update/" . ($data['id'] ?? '');
?>
<br>
<h3>Edytuj Zdjęcie</h3>
<br>
<form action="<?= $action ?>" method="POST" enctype="multipart/form-data" class="timetable-create-form">
	<input type="hidden" name="csrf_token" value="<?= $params['csrf_token'] ?? '' ?>">
    <input type="hidden" name="id" value = "<?= $data['id'] ?>">
	<label>
		<span>Kategoria: </span>
		<select name="category">
			<option <?= $data['category'] === "training"   ? 'selected' : '' ?> value="training">Trening</option>
			<option <?= $data['category'] === "camp"   ? 'selected' : '' ?> value="camp">Obóz</option>
		</select>
	</label>
	<p class="validation-error"><?= $params['flash']['message']['category'] ?? ""  ?></p>
	<label>
		<span>Opis: </span>
		<input type="text" name="description" maxlength="500" placeholder="Opis..." value="<?= $data['description'] ?>">
	</label>
	<p class="validation-error"><?= $params['flash']['message']['description'] ?? ""  ?></p>
	<label>
		<span>Zdjęcie:</span>
		<img class="dashboard-image" src="public/images/karate/<?= $data['image_name'] ?>" alt="">
	</label>
	<input type="submit" value="Zapisz">
</form>