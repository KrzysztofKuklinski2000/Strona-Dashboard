<?php

declare(strict_types=1);

return [
    // Włącz tylko dla wdrożenia korzystającego z mapy dawnych adresów klubu.
    'enabled' => filter_var(
        $_ENV['LEGACY_REDIRECTS_ENABLED'] ?? $_SERVER['LEGACY_REDIRECTS_ENABLED'] ?? false,
        FILTER_VALIDATE_BOOLEAN,
    ),
    'map' => dirname(__DIR__) . '/deployment/redirects/legacy.php',
];
