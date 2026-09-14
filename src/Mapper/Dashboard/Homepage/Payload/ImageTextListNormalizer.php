<?php

declare(strict_types=1);

namespace App\Mapper\Dashboard\Homepage\Payload;

use App\Core\Validator;
use App\Mapper\Dashboard\Payload\OptionalLinkNormalizer;
use App\Mapper\Dashboard\Payload\PayloadNormalizerInterface;

final readonly class ImageTextListNormalizer implements PayloadNormalizerInterface
{
    private const MAX_LIST_ITEMS = 20;

    public function __construct(
        private Validator $validator,
        private OptionalLinkNormalizer $linkNormalizer,
    ) {
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
            'link' => $this->linkNormalizer->normalize($rawPayload['link'] ?? []),
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

    private function isSafeInternalPath(string $path): bool
    {
        return str_starts_with($path, '/')
            && !str_starts_with($path, '//')
            && !str_contains($path, '\\')
            && preg_match('/[\x00-\x1F\x7F]/', $path) !== 1;
    }
}
