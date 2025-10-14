<?php
$pageTitle = 'Lista postów - Grafik';
$moduleName = 'timetable';
$data = $params['data'] ?? [];
$csrfToken = $params['csrf_token'] ?? '';

$tableHeadersHtml = <<<HTML
    <th>Dzień</th>
    <th>Miasto</th>
    <th>Grupa</th>
    <th>Start</th>
    <th>Koniec</th>
    <th>Status</th>
HTML;

$tableRowPartialPath = 'templates/dashboard/_partials/_row_timetable.php';
require 'templates/dashboard/_partials/_list_layout.php';