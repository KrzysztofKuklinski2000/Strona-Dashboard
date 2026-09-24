<?php

declare(strict_types=1);

namespace App\Mapper\Dashboard\Payload;

use App\Core\Validator;

final readonly class OptionalLinkNormalizer
{
    public function __construct(private Validator $validator)
    {
    }

    public function normalize(mixed $rawLink, bool $requireCompleteData = true): array
    {
        if (!is_array($rawLink)) {
            $this->validator->addError(
                'payload.link',
                'Nieprawidłowe dane przycisku.',
            );

            return [
                'label' => '',
                'url' => '',
            ];
        }

        $rawLabel = $rawLink['label'] ?? null;
        $rawUrl = $rawLink['url'] ?? null;
        $hasLabel = is_scalar($rawLabel) && trim((string) $rawLabel) !== '';
        $hasUrl = is_scalar($rawUrl) && trim((string) $rawUrl) !== '';

        $label = $this->validator->validate(
            name: 'payload.link.label',
            value: $rawLabel,
            required: $hasUrl && $requireCompleteData,
            maxLength: 80,
        );

        $url = $this->validator->validate(
            name: 'payload.link.url',
            value: $rawUrl,
            required: $hasLabel && $requireCompleteData,
            maxLength: 255,
        );

        $label = $label === null ? '' : (string) $label;
        $url = $url === null ? '' : (string) $url;

        if ($url !== '' && !$this->isAllowedLink($url)) {
            $this->validator->addError(
                'payload.link.url',
                'Adres musi być ścieżką wewnętrzną albo poprawnym adresem HTTP/HTTPS.',
            );

            $url = '';
        }

        return [
            'label' => $label,
            'url' => $url,
        ];
    }

    private function isAllowedLink(string $url): bool
    {
        $isInternalPath = str_starts_with($url, '/')
            && !str_starts_with($url, '//')
            && !str_contains($url, '\\')
            && preg_match('/[\x00-\x1F\x7F]/', $url) !== 1;

        if ($isInternalPath) {
            return true;
        }

        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            return false;
        }

        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));

        return in_array($scheme, ['http', 'https'], true);
    }
}
