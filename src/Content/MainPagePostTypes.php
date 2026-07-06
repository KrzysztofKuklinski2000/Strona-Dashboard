<?php

namespace App\Content;

final class MainPagePostTypes
{
    public const SIMPLE_TEXT = 'simple_text';
    public const CARDS_GRID = 'cards_grid';
    public const IMAGE_TEXT_LIST = 'image_text_list';

    private const TYPES = [
        self::SIMPLE_TEXT => [
            'label' => 'Prosty tekst',
            'partial' => 'simple_text.php',
        ],
        self::CARDS_GRID => [
            'label' => 'Kafelki',
            'partial' => 'cards_grid.php',
        ],
        self::IMAGE_TEXT_LIST => [
            'label' => 'Obrazek + tekst + lista',
            'partial' => 'image_text_list.php',
        ]
    ];


    public static function all(): array {
        return self::TYPES;
    }

    public static function get(string $type): ?array {
        return self::TYPES[$type] ?? null;
    }

    public static function isAllowed(string $key): bool {
        return array_key_exists($key, self::TYPES);
    }

    public static function partial(string $type): ?string {
        return self::TYPES[$type]['partial'] ?? null;
    }
}
