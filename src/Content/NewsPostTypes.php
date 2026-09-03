<?php

namespace App\Content;

final class NewsPostTypes
{
    public const ARTICLE = 'article';
    public const EVENT = 'event';

    private const TYPES = [
        self::ARTICLE => [
            'label' => 'Zwykły artykół',
            'partial' => 'article.php'
        ],
        self::EVENT => [
            'label' => 'Wydarzenie',
            'partial' => 'event.php',
        ]
    ];


    public static function all(): array
    {
        return self::TYPES;
    }

    public static function get(string $type): ?array
    {
        return self::TYPES[$type] ?? null;
    }

    public static function isAllowed(string $key): bool
    {
        return array_key_exists($key, self::TYPES);
    }

    public static function partial(string $type): ?string
    {
        return self::TYPES[$type]['partial'] ?? null;
    }
}