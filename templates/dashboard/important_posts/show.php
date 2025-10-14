<?php
$data = $params['data'];
$action = "/?dashboard=important_posts&action=published&id=" . ($data['id'] ?? '');
$csrf = $params['csrf_token'] ?? '';
$formTitle = "Szczegóły posta ważnych informacji";

$postDetailsHtml = <<<HTML
  <h4>Tytuł: $data[title] </h4>
  <p>$data[description] </p>
HTML;

require "templates/dashboard/_partials/_show_form.php";