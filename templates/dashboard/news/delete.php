<?php
$data = $params['data'];
$action = "/dashboard/news/delete/" . ($data->id ?? '');
$formTitle = "Usuń posta aktualności";
$buttonTitle = "Usuń";
$csrf = $params['csrf_token'] ?? '';

$postDetailsHtml = sprintf(
    '<h4> Tytuł posta: %s </h4>',
    e($data->title ?? '')
);

require "templates/dashboard/_partials/_delete_form.php";