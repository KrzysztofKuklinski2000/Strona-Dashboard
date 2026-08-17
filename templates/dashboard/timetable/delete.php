<?php 
$data = $params['data'];
$action = "/dashboard/timetable/delete/" . ($data->id ?? '');
$csrf = $params['csrf_token'] ?? '';
?>

<h3 class="dashboard-action-header">Usuwanie wpisu z grafiku</h3>
<p><b>Dzień:</b> <?= e($data->day) ?> </p>
<p><b>Miasto:</b> <?= e($data->city) ?> </p>
<p><b>Grupa:</b> <?= e($data->advancementGroup) ?></p>
<p><b>Szczegóły:</b> <?= e($data->place) ?></p>
<p><b>Start:</b> <?= e($data->start) ?></p>
<p><b>Koniec:</b> <?= e($data->end) ?></p>
<form action="<?= e($action) ?>" method="POST">
  <input type="hidden" name="csrf_token" value="<?= e($csrf ?? "") ?>">
  <label>
    <input type="checkbox" name="is_notify">
		Powiadom
	</label>
  <input type="submit" value="Usuń"> 
</form>
