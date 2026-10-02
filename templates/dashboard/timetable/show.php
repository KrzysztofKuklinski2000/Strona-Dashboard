<?php 
	$data = $params['data'];
	$action = "/dashboard/timetable/published/" . ($data->id ?? '');
	$csrf = $params['csrf_token'] ?? '';
?>

<h3 class="dashboard-action-header">Szczegóły wpisu w grafiku</h3>
<div class="post-content">
 <h4>Dzień: <?= e($data->day) ?></h4>
	<h4>Lokalizacja:
    <a href="/dashboard/timetable/location/show/<?= e($data->locationId) ?>">
      Lokalizacja #<?= e($data->locationId) ?>
    </a>
  </h4>
	<h4>Grupa: <?= e($data->advancementGroup) ?></h4>
	<h4>Start: <?= e($data->start) ?></h4>
	<h4>Koniec: <?= e($data->end) ?></h4>
</div>
  <form action="<?= e($action) ?>" method="POST">
    <input type="hidden" name="csrf_token" value="<?= e($csrf ?? '') ?>">
    <input type="hidden" name="postId" value="<?= e($data->id ?? "") ?>">
    <label>
      <input type="radio" name="postPublished" value='1' <?= $data->status == 1 ? 'checked' : '' ?>> Publiczny
    </label>
    <label>
      <input type="radio" name="postPublished" value='0' <?= $data->status == 0 ? 'checked' : '' ?>> Niepubliczny
    </label>
	<label>
    <input type="checkbox" name="is_notify">
		Powiadom
	</label>
    <input type="submit" value="Zapisz">
  </form>
