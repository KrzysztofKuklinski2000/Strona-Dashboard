<?php
$data = $params['data'];
$action = "/dashboard/news/published/" . ($data->id ?? '');
$csrf = $params['csrf_token'] ?? '';
$formTitle = "Szczegóły posta aktualności";

$postDetailsHtml = sprintf(
    '<h4>Tytuł: %s</h4><p>%s</p>',
    e($data->title),
    e_br($data->description),
);

require "templates/dashboard/_partials/_show_form.php";