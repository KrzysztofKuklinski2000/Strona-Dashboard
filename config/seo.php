<?php

declare(strict_types=1);

$publicHosts = $_ENV['APP_INDEXING_HOSTS'] ?? $_SERVER['APP_INDEXING_HOSTS'] ?? '';
$publicHosts = is_string($publicHosts) ? $publicHosts : '';

return [
    'indexing_enabled' => filter_var(
        $_ENV['APP_INDEXING_ENABLED'] ?? $_SERVER['APP_INDEXING_ENABLED'] ?? false,
        FILTER_VALIDATE_BOOLEAN,
    ),
    // Pusta lista blokuje indeksowanie, nawet gdy sama flaga jest włączona.
    'public_hosts' => array_values(array_unique(array_filter(
        array_map(static fn (string $host): string => strtolower(trim($host)), explode(',', $publicHosts)),
        static fn (string $host): bool => $host !== '',
    ))),
];
