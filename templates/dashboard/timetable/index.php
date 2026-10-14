<?php
$pageTitle = 'Lista postów - Grafik';
$moduleName = 'timetable';
$data = $params['data'] ?? [];
$csrfToken = $params['csrf_token'] ?? '';
$notificationReport = $params['notification_report'] ?? null;
$additionalHeaderActions = [
    [
        'label' => 'Lokalizacje',
        'url' => '/dashboard/timetable/location',
        'icon' => 'fa-solid fa-location-dot',
        'variant' => 'secondary',
    ],
];

$tableHeadersHtml = <<<HTML
    <th>Dzień</th>
    <th>Lokalizacja</th>
    <th>Grupa</th>
    <th>Start</th>
    <th>Koniec</th>
    <th>Status</th>
HTML;

$tableRowPartialPath = 'templates/dashboard/_partials/_row_timetable.php';
require 'templates/dashboard/timetable/_notification_report.php';
require 'templates/dashboard/_partials/_list_layout.php';
