<?php
$data = $params['data'];
$action = "/dashboard/gallery/published/" . ($data->id ?? '');
$csrf = $params['csrf_token'] ?? '';
$formTitle = "Szczegóły posta ważnych informacji";

$postDetailsHtml = sprintf(
    '<img class="dashboard-image" src="/public/uploads/%s" alt="%s">
     <p>%s</p>',
    rawurlencode($data->imageName),
    e($data->description),
    e($data->description)
);

require "templates/dashboard/_partials/_show_form.php";
?>