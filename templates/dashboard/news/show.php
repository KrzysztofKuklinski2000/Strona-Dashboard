<?php
$data = $params['data'];
$action = "/dashboard/news/published/" . ($data['id'] ?? '');
$csrf = $params['csrf_token'] ?? '';
$formTitle = "Szczegóły posta aktualności";

$postDetailsHtml = <<<HTML
  <h4>Tytuł: $data[title] </h4>
  <p>$data[description] </p>
HTML;

require "templates/dashboard/_partials/_show_form.php";