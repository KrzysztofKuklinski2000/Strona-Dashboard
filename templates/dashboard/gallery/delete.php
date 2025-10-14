<?php 
$data = $params['data'];
$action = "/?dashboard=gallery&action=delete&id=" . ($data['id'] ?? '');
$formTitle = "Usuń posta z grafiku";
$csrf = $params['csrf_token'] ?? '';

$postDetailsHtml = <<<HTML
  <img class="dashboard-image" src="public/images/karate/$data[image_name]" alt="Zdjęcie z galerii">
	<p><b>Opis:</b> $data[description]</p>
	<p><b>Data Utworzenia:</b> $data[created_at]</p>
HTML;

require "templates/dashboard/_partials/_delete_form.php";