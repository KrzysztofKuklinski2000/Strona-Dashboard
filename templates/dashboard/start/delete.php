<?php
$data = $params['data'];
$action = "/dashboard/start/delete/" . ($data['id'] ?? '');
$formTitle = "Usuń posta z strony głównej";
$csrf = $params['csrf_token'] ?? '';

$postDetailsHtml = <<<HTML
  <h4>Tytuł posta: $data[title] </h4>
HTML;

require "templates/dashboard/_partials/_delete_form.php";