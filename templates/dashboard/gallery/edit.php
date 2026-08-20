<?php
	$data = $params['data'];
	$action = "/dashboard/gallery/update/" . ($data->id ?? '');
?>
<h3 class="dashboard-action-header">Edytowanie zdjęcia</h3>
<form action="<?= e($action) ?>" method="POST" enctype="multipart/form-data" class="timetable-create-form">
	<input type="hidden" name="csrf_token" value="<?= e($params['csrf_token'] ?? '') ?>">
    <input type="hidden" name="id" value = "<?= e($data->id) ?>">
	<label>
		<span>Kategoria: </span>
		<select name="category">
			<option <?= $data->category === "training"   ? 'selected' : '' ?> value="training">Trening</option>
			<option <?= $data->category === "camp"   ? 'selected' : '' ?> value="camp">Obóz</option>
		</select>
	</label>
	<p class="validation-error"><?= e($params['flash_dashboard']['message']['category'] ?? "")  ?></p>
	<label>
		<span>Opis: </span>
		<input type="text" name="description" maxlength="50" placeholder="Opis..." value="<?= e($data->description) ?>">
	</label>
	<p class="validation-error"><?= e($params['flash_dashboard']['message']['description'] ?? "")  ?></p>
    <label>
        <span>Zdjęcie:</span>
        <input type="file" name="image_name" accept="image/jpeg,image/png,image/gif">
    </label>
    <p class="validation-error"><?= e($params['flash_dashboard']['message']['image_name'] ?? "")  ?></p>
	<input type="submit" value="Zapisz">
</form>
