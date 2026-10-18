<?php
return [
    'env' => $_ENV['APP_ENV'] ?? $_SERVER['APP_ENV'] ?? 'prod',
    'app_url' => $_ENV['APP_URL'] ?? $_SERVER['APP_URL'] ?? '',

    'paths' => [
        'templates' => dirname(__DIR__) . '/templates',
        'uploads_dir' => dirname(__DIR__) . '/public/uploads',
        'uploads_url' => '/uploads',
        'routes' => dirname(__DIR__) . '/config/routes.php',
    ],

    'app_settings' => [
        'upload_max_size' => 3_000_000,
        'file_prefix' => 'karate_',
        'dashboard_route' => '/dashboard',
        'login_route' => '/auth/login',
        'home_route' => '/',
        'csrf_token_name' => 'csrf_token',
        'csrf_prefix' => 'csrf_token_',
        'items_per_page' => 10,
    ],

    'db' => [
        'host' => $_ENV['DB_HOST'] ?? $_SERVER['DB_HOST'] ?? '',
        'database' => $_ENV['DB_DATABASE'] ?? $_SERVER['DB_DATABASE'] ?? '',
        'user' => $_ENV['DB_USERNAME'] ?? $_SERVER['DB_USERNAME'] ?? '',
        'password' => $_ENV['DB_PASSWORD'] ?? $_SERVER['DB_PASSWORD'] ?? '',
    ],

    'mail' => [
        'dsn' => $_ENV['MAILER_DSN'] ?? $_SERVER['MAILER_DSN'] ?? '',
        'from_email' => $_ENV['MAIL_FROM_EMAIL'] ?? $_SERVER['MAIL_FROM_EMAIL'] ?? '',
    ],

    'notifications' => [
        'timetable_updated' => 'Wprowadziliśmy zmiany w istniejącym grafiku treningów. Odwiedź stronę, aby zobaczyć zmiany!',
        'timetable_created' => 'Do grafiku dodano nowe zajęcia! Sprawdź szczegóły na stronie.',
        'timetable_published' => 'Grafik został zaktualizowany. Odwiedź stronę, aby zobaczyć zmiany!',
        'timetable_deleted' => 'Pewne zajęcia zostały usunięte z grafiku. Odwiedź stronę, aby zobaczyć zmiany!'
    ],
];
