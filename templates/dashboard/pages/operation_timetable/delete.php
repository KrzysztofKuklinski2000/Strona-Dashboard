<?php 
$actionUrl = "/?dashboard=start&subpage=grafik&operation=delete&id=" . ($data['id'] ?? '');
?>

<br>
<h3>Usuń Dziń Treningowy</h3>
<br> 
<h4>Dzień: <?php echo $data['day'] ?></h4>
<h4>Miasto: <?php echo $data['city'] ?> </h4>
<h4>Grupa: <?php echo $data['advancement_group'] ?></h4>
<h4>Szczegóły: <?php echo $data['place'] ?> </h4>
<h4>Start: <?php echo $data['start'] ?></h4>
<h4>Koniec: <?php echo $data['end'] ?> </h4>
<form action="<?= $actionUrl ?>" method="Post">
	<input type="hidden" name="csrf_token" value="<?php echo $params['csrf_token'] ?? '' ?>">
	<input type="hidden" name="postId" value="<?php echo $data['id'] ?>">
	<input type="submit" value="Usuń">
</form>