<?php 
$data = $params['data'];
$action = "/dashboard/subscribers/delete/" . ($data->id ?? '');
$formTitle = "Usuń subskrybenta";
$csrf = $params['csrf_token'] ?? '';

$postDetailsHtml = sprintf(
    '<h4>%s</h4>',
    e($data->email),
);

require "templates/dashboard/_partials/_delete_form.php";