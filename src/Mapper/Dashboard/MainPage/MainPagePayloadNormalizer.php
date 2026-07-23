<?php

namespace App\Mapper\Dashboard\MainPage;

use App\Content\MainPagePostTypes;
use App\Core\Validator;

class MainPagePayloadNormalizer
{
    private const MAX_MAIN_PAGE_CARDS = 12;
    private const MAX_MAIN_PAGE_LIST_ITEMS = 20;
    public function __construct(private readonly Validator $validator)
    {
    }

    public function normalize(string $type, array $rawPayload): ?string
    {
        if ($type === MainPagePostTypes::SIMPLE_TEXT) {
            return $this->encodeMainPagePayload([
                'description' => $this->validateMainPagePayloadText(
                    name: 'payload.description',
                    value: $rawPayload['description'] ?? null,
                    required: true,
                    minLength: 20,
                    maxLength: 1000,
                ),
            ]);
        }

        if ($type === MainPagePostTypes::CARDS_GRID) {
            return $this->normalizeCardsGridPayload($rawPayload);
        }

        if ($type === MainPagePostTypes::IMAGE_TEXT_LIST) {
            return $this->normalizeImageTextListPayload($rawPayload);
        }

        return null;
    }

    private function normalizeCardsGridPayload(array $rawPayload): string
    {
        $rawCards = $rawPayload['cards'] ?? [];

        if (!is_array($rawCards)) {
            $this->validator->addError('payload.cards', 'Kafelki muszą być przesłane jako lista.');
            $rawCards = [];
        }

        if ($rawCards === []) {
            $this->validator->addError('payload.cards', 'Dodaj przynajmniej jeden kafelek.');
        }

        if (count($rawCards) > self::MAX_MAIN_PAGE_CARDS) {
            $this->validator->addError(
                'payload.cards',
                'Możesz dodać maksymalnie ' . self::MAX_MAIN_PAGE_CARDS . ' kafelków.'
            );
            $rawCards = array_slice($rawCards, 0, self::MAX_MAIN_PAGE_CARDS);
        }

        $cards = [];

        foreach ($rawCards as $index => $rawCard) {
            if (!is_array($rawCard)) {
                $this->validator->addError("payload.cards.$index", 'Nieprawidłowe dane kafelka.');
                continue;
            }

            $cards[] = [
                'icon' => $this->validateMainPagePayloadText(
                    name: "payload.cards.$index.icon",
                    value: $rawCard['icon'] ?? null,
                    maxLength: 80,
                ),
                'title' => $this->validateMainPagePayloadText(
                    name: "payload.cards.$index.title",
                    value: $rawCard['title'] ?? null,
                    required: true,
                    maxLength: 80,
                ),
                'description' => $this->validateMainPagePayloadText(
                    name: "payload.cards.$index.description",
                    value: $rawCard['description'] ?? null,
                    required: true,
                    maxLength: 500,
                ),
            ];
        }

        return $this->encodeMainPagePayload([
            'eyebrow' => $this->validateMainPagePayloadText(
                name: 'payload.eyebrow',
                value: $rawPayload['eyebrow'] ?? null,
                maxLength: 80,
            ),
            'cards' => $cards,
        ]);
    }

    private function normalizeImageTextListPayload(array $rawPayload): string
    {
        $rawImage = $rawPayload['image'] ?? [];

        if (!is_array($rawImage)) {
            $this->validator->addError('payload.image', 'Nieprawidłowe dane obrazu.');
            $rawImage = [];
        }

        $imageSrc = $this->validateMainPagePayloadText(
            name: 'payload.image.src',
            value: $rawImage['src'] ?? null,
            maxLength: 255,
        );

        if ($imageSrc !== '' && !$this->isSafeInternalPath($imageSrc)) {
            $this->validator->addError('payload.image.src', 'Nieprawidłowy adres obrazu.');
            $imageSrc = '';
        }

        return $this->encodeMainPagePayload([
            'eyebrow' => $this->validateMainPagePayloadText(
                name: 'payload.eyebrow',
                value: $rawPayload['eyebrow'] ?? null,
                maxLength: 80,
            ),
            'description' => $this->validateMainPagePayloadText(
                name: 'payload.description',
                value: $rawPayload['description'] ?? null,
                required: true,
                minLength: 20,
                maxLength: 1000,
            ),
            'image' => [
                'src' => $imageSrc,
                'alt' => $this->validateMainPagePayloadText(
                    name: 'payload.image.alt',
                    value: $rawImage['alt'] ?? null,
                    maxLength: 160,
                ),
            ],
            'items' => $this->normalizeMainPageListItems($rawPayload['items'] ?? []),
            'link' => $this->normalizeMainPageLink($rawPayload['link'] ?? []),
        ]);
    }

    private function normalizeMainPageListItems(mixed $rawItems): array
    {
        if (!is_array($rawItems)) {
            $this->validator->addError('payload.items', 'Punkty muszą być przesłane jako lista.');
            return [];
        }

        if (count($rawItems) > self::MAX_MAIN_PAGE_LIST_ITEMS) {
            $this->validator->addError(
                'payload.items',
                'Możesz dodać maksymalnie ' . self::MAX_MAIN_PAGE_LIST_ITEMS . ' punktów.'
            );
            $rawItems = array_slice($rawItems, 0, self::MAX_MAIN_PAGE_LIST_ITEMS);
        }

        $items = [];

        foreach ($rawItems as $index => $rawItem) {
            $item = $this->payloadText($rawItem);

            if ($item === null) {
                $this->validator->addError("payload.items.$index", 'Nieprawidłowa treść punktu.');
                continue;
            }

            if ($item === '') {
                continue;
            }

            $validatedItem = $this->validator->validate(
                name: "payload.items.$index",
                value: $item,
                maxLength: 160,
            );

            if ($validatedItem !== null) {
                $items[] = (string) $validatedItem;
            }
        }

        return $items;
    }

    private function normalizeMainPageLink(mixed $rawLink): array
    {
        if (!is_array($rawLink)) {
            $this->validator->addError('payload.link', 'Nieprawidłowe dane przycisku.');
            return ['label' => '', 'url' => ''];
        }

        $rawLabelValue = $rawLink['label'] ?? null;
        $rawUrlValue = $rawLink['url'] ?? null;

        if ($rawLabelValue !== null && !is_scalar($rawLabelValue)) {
            $this->validator->addError('payload.link.label', 'Nieprawidłowa wartość pola.');
        }

        if ($rawUrlValue !== null && !is_scalar($rawUrlValue)) {
            $this->validator->addError('payload.link.url', 'Nieprawidłowa wartość pola.');
        }

        $rawLabel = $this->payloadText($rawLabelValue) ?? '';
        $rawUrl = $this->payloadText($rawUrlValue) ?? '';

        if ($rawLabel === '' && $rawUrl === '') {
            return ['label' => '', 'url' => ''];
        }

        $label = $this->validateMainPagePayloadText(
            name: 'payload.link.label',
            value: $rawLabel,
            required: true,
            maxLength: 80,
        );
        $url = $this->validateMainPagePayloadText(
            name: 'payload.link.url',
            value: $rawUrl,
            required: true,
            maxLength: 255,
        );

        if ($url !== '' && !$this->isAllowedMainPageLink($url)) {
            $this->validator->addError(
                'payload.link.url',
                'Adres musi być ścieżką wewnętrzną albo poprawnym adresem HTTP/HTTPS.'
            );
            $url = '';
        }

        return ['label' => $label, 'url' => $url];
    }

    private function validateMainPagePayloadText(
        string $name,
        mixed $value,
        bool $required = false,
        ?int $minLength = null,
        ?int $maxLength = null,
    ): string {
        if ($value !== null && !is_scalar($value)) {
            $this->validator->addError($name, 'Nieprawidłowa wartość pola.');
            return '';
        }

        $validatedValue = $this->validator->validate(
            name: $name,
            value: $this->payloadText($value),
            required: $required,
            minLength: $minLength,
            maxLength: $maxLength,
        );

        return $validatedValue === null ? '' : (string) $validatedValue;
    }

    private function payloadText(mixed $value): ?string
    {
        return is_scalar($value) ? trim((string) $value) : null;
    }

    private function encodeMainPagePayload(array $payload): string
    {
        $json = json_encode($payload, JSON_UNESCAPED_UNICODE);

        if ($json === false) {
            $this->validator->addError('payload', 'Nie udało się zapisać danych posta.');
            return '{}';
        }

        return $json;
    }

    private function isAllowedMainPageLink(string $url): bool
    {
        if ($this->isSafeInternalPath($url)) {
            return true;
        }

        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            return false;
        }

        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));

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