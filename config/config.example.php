<?php
return [
    'env' => 'dev',
    'app_url' => 'http://localhost:8000',

    'paths' => [
        'templates' => dirname(__DIR__) . '/templates',
        'uploads_dir' => dirname(__DIR__) . '/public/uploads',
        'uploads_url' => '/public/uploads',
        'routes' => dirname(__DIR__) . '/config/routes.php',
    ],

    'app_settings' => [
        'upload_max_size' => 5_000_000,
        'file_prefix' => 'karate_',
        'dashboard_route' => '/dashboard',
        'login_route' => '/auth/login',
        'home_route' => '/',
        'csrf_token_name' => 'csrf_token',
        'csrf_prefix' => 'csrf_token_',
        'items_per_page' => 10,
    ],

    'db' => [
        'host' => 'db',
        'database' => 'karate',
        'user' => 'user_karate',
        'password' => 'haslo'
    ],

    'mail' => [
        'host' => 'mailpit',
        'port' => 1025,
        'username' => null,
        'password' => null,
        'from_email' => 'powiadomienia@twojastrona.pl',
    ],

    'notifications' => [
        'timetable_updated' => 'Wprowadziliśmy zmiany w istniejącym grafiku treningów. Odwiedź stronę, aby zobaczyć zmiany!',
        'timetable_created' => 'Do grafiku dodano nowe zajęcia! Sprawdź szczegóły na stronie.',
        'timetable_published' => 'Grafik został zaktualizowany. Odwiedź stronę, aby zobaczyć zmiany!',
        'timetable_deleted' => 'Pewne zajęcia zostały usunięte z grafiku. Odwiedź stronę, aby zobaczyć zmiany!'
    ],
];
