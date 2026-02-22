<?php
$pageTitle = 'Lista postów - Galeria';
$moduleName = 'gallery';
$data = $params['data'] ?? [];
$csrf = $params['csrf_token'] ?? '';
$action = '/dashboard/gallery/move';
$showPosition = true;

$tableHeadersHtml = <<<HTML
    <th>Zdjęcie</th>
    <th>Opis</th>
    <th>Data</th>
    <th>Status</th>
HTML;

$tableRowPartialPath = 'templates/dashboard/_partials/_row_gallery.php';
require 'templates/dashboard/_partials/_list_layout.php';