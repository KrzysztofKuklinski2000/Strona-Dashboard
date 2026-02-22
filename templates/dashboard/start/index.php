<?php
$data = $params['data'] ?? [];
$action = '/dashboard/start/move';
$moduleName = 'start';
$pageTitle = 'Strona główna - Lista postów';
$csrf = $params['csrf_token'] ?? '';
$showPosition = true;


$tableHeadersHtml = <<<HTML
    <th>Tytuł</th>
    <th>Data</th>
    <th>Status</th>
HTML;

$tableRowPartialPath = 'templates/dashboard/_partials/_row_base.php';
require "templates/dashboard/_partials/_list_layout.php";
