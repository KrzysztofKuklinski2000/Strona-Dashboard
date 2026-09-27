<?php

declare(strict_types=1);

$data = $params['data'];
$action = '/dashboard/gallery/categories/delete/' . ($data->id ?? '');
$formTitle = 'Usuwanie kategorii galerii';
$csrf = $params['csrf_token'] ?? '';

$postDetailsHtml = sprintf(
    '<h4>%s</h4>
     <p><b>Slug:</b> %s</p>
     <p>Usunięcie kategorii usunie przypisania zdjęć do tej kategorii.</p>',
    e($data->name ?? ''),
    e($data->slug ?? ''),
);

require 'templates/dashboard/_partials/_delete_form.php';
