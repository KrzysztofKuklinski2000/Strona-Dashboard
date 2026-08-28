<?php

namespace App\Content;

final readonly class HomepageFeedModules
{
    public const NEWS = 'news';

    private const MODULES = [
        self::NEWS => [
            'label' => 'Aktualności',
            'url' => '/aktualnosci',
            'partial' => 'news.php',
        ],
    ];


    public static function all(): array {
        return self::MODULES;
    }

    public static function get(string $module): ?array {
        return self::MODULES[$module] ?? null;
    }

    public static function isAllowed(string $module): bool {
        return array_key_exists($module, self::MODULES);
    }
}