<?php

declare(strict_types=1);

namespace App\Core;

final class UploadPath
{
    public const MODULES = ['gallery', 'news', 'homepage'];

    /** Obsługuje stare nazwy plików i nowe ścieżki względem katalogu uploads. */
    public static function isValid(string $path): bool
    {
        return preg_match(
            '~\A(?:(?:gallery|news|homepage)/)?[a-z0-9][a-z0-9._-]*\.(?:jpe?g|png|gif|webp)\z~i',
            $path,
        ) === 1;
    }

    public static function toUrl(string $path): string
    {
        if (!self::isValid($path)) {
            return '';
        }

        return '/uploads/' . implode('/', array_map('rawurlencode', explode('/', $path)));
    }
}
