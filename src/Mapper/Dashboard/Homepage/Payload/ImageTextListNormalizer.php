<?php

declare(strict_types=1);

namespace App\Mapper\Dashboard\Homepage\Payload;

use App\Core\Validator;
use App\Mapper\Dashboard\Payload\PayloadNormalizerInterface;

final readonly class ImageTextListNormalizer implements PayloadNormalizerInterface
{
    private const MAX_LIST_ITEMS = 20;

    public function __construct(private Validator $validator)
    {
    }

    public function normalize(array $rawPayload): array
    {
        $rawImage = $rawPayload['image'] ?? [];

        if (!is_array($rawImage)) {
            $this->validator->addError(
                'payload.image',
                'Nieprawidłowe dane obrazu.'
            );

            $rawImage = [];
        }

        $imageSrcValue = $this->validator->validate(
            name: 'payload.image.src',
            value: $rawImage['src'] ?? null,
            maxLength: 255,
        );

        $imageSrc = $imageSrcValue === null ? '' : (string)$imageSrcValue;

        if ($imageSrc !== '' && !$this->isSafeInternalPath($imageSrc)) {
            $this->validator->addError(
                'payload.image.src',
                'Nieprawidłowy adres obrazu.'
            );

            $imageSrc = '';
        }

        $eyebrow = $this->validator->validate(
            name: 'payload.eyebrow',
            value: $rawPayload['eyebrow'] ?? null,
            maxLength: 80,
        );

        $description = $this->validator->validate(
            name: 'payload.description',
            value: $rawPayload['description'] ?? null,
            required: true,
            minLength: 20,
            maxLength: 1000,
        );


        $alt = $this->validator->validate(
            name: 'payload.image.alt',
            value: $rawImage['alt'] ?? null,
            maxLength: 160,
        );

        return [
            'eyebrow' => $eyebrow === null ? '' : (string)$eyebrow,
            'description' => $description === null ? '' : (string)$description,
            'image' => [
                'src' => $imageSrc,
                'alt' => $alt === null ? '' : (string)$alt,
            ],
            'items' => $this->normalizeListItems($rawPayload['items'] ?? []),
            'link' => $this->normalizeLink($rawPayload['link'] ?? []),
        ];
    }

    private function normalizeListItems(mixed $rawItems): array
    {

        if (!is_array($rawItems)) {
            $this->validator->addError(
                'payload.items',
                'Punkty muszą być przesłane jako lista.'
            );

            return [];
        }

        if (count($rawItems) > self::MAX_LIST_ITEMS) {
            $this->validator->addError(
                'payload.items',
                'Możesz dodać maksymalnie ' . self::MAX_LIST_ITEMS . ' punktów.'
            );

            $rawItems = array_slice($rawItems, 0, self::MAX_LIST_ITEMS);
        }

        $items = [];

        foreach ($rawItems as $index => $rawItem) {
            if (!is_scalar($rawItem)) {
                $this->validator->addError(
                    "payload.items.$index",
                    'Nieprawidłowa treść punktu.',
                );

                continue;
            }

            $rawItem = trim((string)$rawItem);

            if ($rawItem === '') {
                continue;
            }

            $item = $this->validator->validate(
                name: "payload.items.$index",
                value: $rawItem,
                maxLength: 160,
            );

            if ($item !== null) {
                $items[] = (string)$item;
            }
        }

        return $items;
    }

    private function normalizeLink(mixed $rawLink): array
    {
        if (!is_array($rawLink)) {
            $this->validator->addError(
                'payload.link',
                'Nieprawidłowe dane przycisku.'
            );

            return [
                'label' => '',
                'url' => ''
            ];
        }

        $rawLabelValue = $rawLink['label'] ?? null;
        $rawUrlValue = $rawLink['url'] ?? null;

        if ($rawLabelValue !== null && !is_scalar($rawLabelValue)) {
            $this->validator->addError(
                'payload.link.label',
                'Nieprawidłowa wartość pola.'
            );
        }

        if ($rawUrlValue !== null && !is_scalar($rawUrlValue)) {
            $this->validator->addError(
                'payload.link.url',
                'Nieprawidłowa wartość pola.'
            );
        }

        $rawLabel = is_scalar($rawLabelValue)
            ? trim((string)$rawLabelValue)
            : '';

        $rawUrl = is_scalar($rawUrlValue)
            ? trim((string)$rawUrlValue)
            : '';

        if ($rawLabel === '' && $rawUrl === '') {
            return [
                'label' => '',
                'url' => ''
            ];
        }

        $label = $this->validator->validate(
            name: 'payload.link.label',
            value: $rawLabel,
            required: true,
            maxLength: 80,
        );

        $url = $this->validator->validate(
            name: 'payload.link.url',
            value: $rawUrl,
            required: true,
            maxLength: 255,
        );

        $label = $label === null ? '' : (string)$label;
        $url = $url === null ? '' : (string)$url;

        if ($url !== '' && !$this->isAllowedLink($url)) {
            $this->validator->addError(
                'payload.link.url',
                'Adres musi być ścieżką wewnętrzną albo poprawnym adresem HTTP/HTTPS.'
            );

            $url = '';
        }

        return [
            'label' => $label,
            'url' => $url
        ];
    }


    private function isAllowedLink(string $url): bool
    {
        if ($this->isSafeInternalPath($url)) {
            return true;
        }

        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            return false;
        }

        $scheme = strtolower((string)parse_url($url, PHP_URL_SCHEME));

        return in_array($scheme, ['http', 'https'], true);
    }

    private function isSafeInternalPath(string $path): bool
    {
        return str_starts_with($path, '/')
            && !str_starts_with($path, '//')
            && !str_contains($path, '\\')
            && preg_match('/[\x00-\x1F\x7F]/', $path) !== 1;
    }
}
