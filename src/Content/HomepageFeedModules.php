<?php

namespace App\Content;

final readonly class HomepageFeedModules
{
    public const NEWS = 'news';

    public const GALLERY = 'gallery';
    public const IMPORTANT_POSTS = 'important_posts';

    private const MODULES = [
        self::NEWS => [
            'label' => 'Aktualności',
            'url' => '/aktualnosci',
            'partial' => 'news.php',
        ],
        self::GALLERY => [
            'label' => 'Galeria',
            'url' => '/galeria',
            'partial' => 'gallery.php',
        ],
        self::IMPORTANT_POSTS => [
            'label' => 'Ważne informacje',
            'url' => null,
            'partial' => 'important_posts.php',
        ]
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