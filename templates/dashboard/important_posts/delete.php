<?php
$data = $params['data'];
$action = "/?dashboard=important_posts&action=delete&id=" . ($data['id'] ?? '');
$formTitle = "Usuń ważnego posta";
$csrf = $params['csrf_token'] ?? '';

$postDetailsHtml = <<<HTML
  <h4>Tytuł posta: $data[title] </h4>
HTML;

require "templates/dashboard/_partials/_delete_form.php";