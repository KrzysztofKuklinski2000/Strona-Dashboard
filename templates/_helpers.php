<?php
declare(strict_types=1);

if (!function_exists('e')) {
    function e(mixed $value): string
    {
        return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

if (!function_exists('e_br')) {
    function e_br(mixed $value): string
    {
        return nl2br(e($value));
    }
}

if (!function_exists('upload_url')) {
    function upload_url(string $path): string
    {
        return \App\Core\UploadPath::toUrl($path);
    }
}
