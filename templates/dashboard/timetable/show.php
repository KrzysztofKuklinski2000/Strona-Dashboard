<?php 
	$data = $params['data'];
	$action = "/dashboard/timetable/published/" . ($data['id'] ?? '');
	$csrf = $params['csrf_token'] ?? '';
?>

<br>
<h3>Szczegóły posta ważnych informacji</h3>
<br>
<div class="post-content">
 <h4>Dzień: <?= $data['day'] ?></h4>
	<h4>Miasto: <?= $data['city']?></h4>
	<h4>Grupa: <?= $data['advancement_group']?></h4>
	<h4>Szczegóły: <?= $data['place']?></h4>
	<h4>Start: <?= $data['start']?></h4>
	<h4>Koniec: <?= $data['end']?></h4>
</div>
  <form action="<?= $action ?>" method="POST">
    <input type="hidden" name="csrf_token" value="<?= $csrf ?? '' ?>">
    <input type="hidden" name="postId" value="<?= $data['id'] ?? "" ?>">
    <label>
      <input type="radio" name="postPublished" value='1' <?= $data['status'] == 1 ? 'checked' : '' ?>> Publiczny
    </label>
    <label>
      <input type="radio" name="postPublished" value='0' <?= $data['status'] == 0 ? 'checked' : '' ?>> Niepubliczny
    </label>
	<label>
    <input type="checkbox" name="is_notify">
		Powiadom
	</label>
    <input type="submit" value="Zapisz">
  </form>
</div>