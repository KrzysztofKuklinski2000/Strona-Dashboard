<?php 
	$data = $params['data'];
	$action = "/?dashboard=timetable&action=published&id=" . ($data['id'] ?? '');
	$csrf = $params['csrf_token'] ?? '';
	$formTitle = "Szczegóły posta ważnych informacji";

	$postDetailsHtml = <<<HTML
  <h4>Dzień: $data[day]</h4>
	<h4>Miasto: $data[city]</h4>
	<h4>Grupa: $data[advancement_group]</h4>
	<h4>Szczegóły: $data[place] </h4>
	<h4>Start: $data[start] </h4>
	<h4>Koniec: $data[end]</h4>
HTML;


require "templates/dashboard/_partials/_show_form.php"
?>