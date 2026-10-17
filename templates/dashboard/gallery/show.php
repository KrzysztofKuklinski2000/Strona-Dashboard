<?php
$data = $params['data'];
$action = "/dashboard/gallery/published/" . ($data->id ?? '');
$csrf = $params['csrf_token'] ?? '';
$formTitle = "Szczegóły posta ważnych informacji";

$postDetailsHtml = sprintf(
    '<img class="dashboard-image" src="%s" alt="%s">
     <p>%s</p>',
    e(upload_url($data->imageName)),
    e($data->description),
    e($data->description)
);

require "templates/dashboard/_partials/_show_form.php";
?>
