<?php 
$data = $params['data'];
$action = "/dashboard/timetable/delete/" . ($data->id ?? '');
$csrf = $params['csrf_token'] ?? '';
?>

<h3 class="dashboard-action-header">Usuwanie wpisu z grafiku</h3>
<p><b>Dzień:</b> <?= $data->day?> </p>
<p><b>Miasto:</b> <?= $data->city?> </p>
<p><b>Grupa:</b> <?= $data->advancementGroup?></p>
<p><b>Szczegóły:</b> <?= e($data->place) ?></p>
<p><b>Start:</b> <?= $data->start?></p>
<p><b>Koniec:</b> <?= $data->end ?></p>
<form action="<?= $action ?>" method="POST">
  <input type="hidden" name="csrf_token" value="<?= $csrf ?? "" ?>">
  <input type="hidden" name="postId" value="<?= $data->id ?? "" ?>">
  <label>
    <input type="checkbox" name="is_notify">
		Powiadom
	</label>
  <input type="submit" value="Usuń"> 
</form>
