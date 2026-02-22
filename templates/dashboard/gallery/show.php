<?php
$data = $params['data'];
$action = "/dashboard/gallery/published/" . ($data['id'] ?? '');
$csrf = $params['csrf_token'] ?? '';
$formTitle = "Szczegóły posta ważnych informacji";

$postDetailsHtml = <<<HTML
  <img class="dashboard-image" src="public/images/karate/$data[image_name]" alt="">
	<p> $data[description]</p>
HTML;

require "templates/dashboard/_partials/_show_form.php";
?>