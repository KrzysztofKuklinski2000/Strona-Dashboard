<?php 
$data = $params['data'];
$action = "/dashboard/gallery/delete/" . ($data->id ?? '');
$formTitle = "Usuń posta z grafiku";
$csrf = $params['csrf_token'] ?? '';

$postDetailsHtml = <<<HTML
  <img class="dashboard-image" src="public/images/karate/$data->imageName" alt="Zdjęcie z galerii">
	<p><b>Opis:</b> $data->description</p>
	<p><b>Data Utworzenia:</b> $data->createdAt</p>
HTML;

require "templates/dashboard/_partials/_delete_form.php";