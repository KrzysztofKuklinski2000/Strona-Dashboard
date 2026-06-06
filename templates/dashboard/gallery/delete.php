<?php 
$data = $params['data'];
$action = "/dashboard/gallery/delete/" . ($data->id ?? '');
$formTitle = "Usuń posta z grafiku";
$csrf = $params['csrf_token'] ?? '';

$postDetailsHtml = sprintf(
    '<img class="dashboard-image" src="/public/uploads/%s" alt="Zdjęcie z galerii">
     <p><b>Opis:</b> %s</p>
     <p><b>Data utworzenia:</b> %s</p>',
    rawurlencode($data->imageName),
    e($data->description),
    e($data->createdAt)
);

require "templates/dashboard/_partials/_delete_form.php";