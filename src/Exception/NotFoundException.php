<?php 
declare(strict_types=1);

namespace App\Exception;

class NotFoundException extends AppException
{
    public const ROUTE_NOT_FOUND = 2001;
    public const RESOURCE_NOT_FOUND = 2002;
    public const PAGE_NOT_FOUND = 2003;

    public static function route(string $path): self
    {
        return new self(
            "Route not found: $path",
            self::ROUTE_NOT_FOUND,
            null,
            ['path' => $path],
            'Strona nie została znaleziona.'
        );
    }

    public static function resource(string $type, mixed $id = null): self
    {
        $context = ['resource_type' => $type];
        if ($id !== null) {
            $context['resource_id'] = $id;
        }

        return new self(
            "Resource not found: $type" . ($id ? " with ID: $id" : ""),
            self::RESOURCE_NOT_FOUND,
            null,
            $context,
            'Nie znaleziono żądanego zasobu.'
        );
    }

    public static function page(string $page): self
    {
        return new self(
            "Page not found: $page",
            self::PAGE_NOT_FOUND,
            null,
            ['page' => $page],
            'Strona nie istnieje.'
        );
    }
}