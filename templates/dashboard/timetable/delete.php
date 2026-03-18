<?php 
$data = $params['data'];
$action = "/dashboard/timetable/delete/" . ($data['id'] ?? '');
$csrf = $params['csrf_token'] ?? '';
?>

<br>
<h3>Usuń posta z grafiku"</h3>
<br>
<p><b>Dzień:</b> <?= $data['day']?> </p>
<p><b>Miasto:</b> <?= $data['city']?> </p>
<p><b>Grupa:</b> <?= $data['advancement_group']?></p>
<p><b>Szczegóły:</b> <?= $data['place']?>/p>
<p><b>Start:</b> <?= $data['start']?></p>
<p><b>Koniec:</b> <?= $data['end'] ?></p>
<form action="<?= $action ?>" method="POST">
  <input type="hidden" name="csrf_token" value="<?= $csrf ?? "" ?>">
  <input type="hidden" name="postId" value="<?= $data['id'] ?? "" ?>">
  <label>
    <input type="checkbox" name="is_notify">
		Powiadom
	</label>
  <input type="submit" value="Usuń"> 
</form>