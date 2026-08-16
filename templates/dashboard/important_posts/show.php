<?php
$data = $params['data'];
$action = "/dashboard/important_posts/published/" . ($data->id ?? '');
$csrf = $params['csrf_token'] ?? '';
$formTitle = "Szczegóły posta ważnych informacji";

$postDetailsHtml = sprintf(
    '<h4>Tytuł: %s</h4><p>%s</p>',
    e($data->title),
    e_br($data->description),
);

require "templates/dashboard/_partials/_show_form.php";