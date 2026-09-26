<?php

declare(strict_types=1);

namespace App\Content;

final class NewsPostTypes
{
    public const ARTICLE = 'article';
    public const EVENT = 'event';
    public const COMPETITION_RESULTS = 'competition_results';
    public const FUNDING = 'funding';

    private const TYPES = [
        self::ARTICLE => [
            'label' => 'Zwykły artykół',
            'partial' => 'article.php',
            'supports_image' => true,
            'details_partial' => 'article.php',
        ],
        self::EVENT => [
            'label' => 'Wydarzenie',
            'partial' => 'event.php',
            'supports_image' => false,
            'details_partial' => 'event.php',
        ],
        self::COMPETITION_RESULTS => [
            'label' => 'Wyniki zawodów',
            'partial' => 'competition_results.php',
            'supports_image' => false,
            'details_partial' => 'competition_results.php',
        ],
        self::FUNDING => [
            'label' => 'Dofinansowania',
            'partial' => 'funding.php',
            'supports_image' => false,
            'details_partial' => 'funding.php',
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

    public static function supportsImage(string $type): bool {
        return (bool) (self::TYPES[$type]['supports_image'] ?? false);
    }

    public static function detailsPartial(string $type): ?string {
        return self::TYPES[$type]['details_partial'] ?? null;
    }
}
