<?php 
$data = $params['data'];
$action = "/?dashboard=timetable&action=delete&id=" . ($data['id'] ?? '');
$formTitle = "Usuń posta z grafiku";
$csrf = $params['csrf_token'] ?? '';

$postDetailsHtml = <<<HTML
  <p><b>Dzień:</b> $data[day] </p>
	<p><b>Miasto:</b> $data[city] </p>
	<p><b>Grupa:</b> $data[advancement_group]</p>
	<p><b>Szczegóły:</b> $data[place]</p>
	<p><b>Start:</b> $data[start]</p>
	<p><b>Koniec:</b> $data[end]</p>
HTML;

require "templates/dashboard/_partials/_delete_form.php";
?>