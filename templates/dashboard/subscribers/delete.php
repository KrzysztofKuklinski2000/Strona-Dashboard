<?php 
$data = $params['data'];
$action = "/dashboard/subscribers/delete/" . ($data['id'] ?? '');
$formTitle = "Usuń subskrybenta";
$csrf = $params['csrf_token'] ?? '';

$postDetailsHtml = <<<HTML
  <h4>$data[email]</h4>
HTML;

require "templates/dashboard/_partials/_delete_form.php";