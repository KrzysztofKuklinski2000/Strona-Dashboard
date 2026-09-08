<?php

declare(strict_types=1);

namespace App\Mapper\Dashboard\News\Payload;

use App\Core\Validator;
use App\Mapper\Dashboard\Payload\PayloadNormalizerInterface;
use DateTimeImmutable;

final readonly class EventNormalizer implements PayloadNormalizerInterface
{
    public function __construct(private Validator $validator)
    {
    }

    public function normalize(array $rawPayload): array
    {
        $eventDate = $this->normalizeDate($rawPayload['event_date'] ?? null);
        $eventStartTime = $this->normalizeTime(
            field: 'payload.start_time',
            value: $rawPayload['start_time'] ?? null,
            required: true,
        );
        $eventEndTime = $this->normalizeTime(
            field: 'payload.end_time',
            value: $rawPayload['end_time'] ?? null,
        );

        if (
            $eventStartTime !== ''
            && $eventEndTime !== ''
            && $eventEndTime <= $eventStartTime
        ) {
            $this->validator->addError(
                'payload.end_time',
                'Godzina zakończenia musi być późniejsza niż godzina rozpoczęcia.',
            );
        }

        $location = $this->validator->validate(
            name: 'payload.location',
            value: $rawPayload['location'] ?? null,
            required: true,
            maxLength: 160
        );

        $description = $this->validator->validate(
            name: 'payload.description',
            value: $rawPayload['description'] ?? null,
            required: true,
            maxLength: 1000,
        );

        return [
            'event_date' => $eventDate,
            'start_time' => $eventStartTime,
            'end_time' => $eventEndTime,
            'description' => $description ?? '',
            'location' => $location ?? '',
            'link' => $this->normalizeLink($rawPayload['link'] ?? []),
        ];
    }

    private function normalizeDate(mixed $rawDate): string
    {
        $date = $this->validator->validate(
            name: 'payload.event_date',
            value: $rawDate,
            required: true,
            maxLength: 10,
        );

        if ($date === null) {
            return '';
        }

        $date = (string) $date;
        $parsedDate = DateTimeImmutable::createFromFormat('!Y-m-d', $date);

        if ($parsedDate === false || $parsedDate->format('Y-m-d') !== $date) {
            $this->validator->addError(
                'payload.event_date',
                'Podaj poprawną datę wydarzenia.',
            );

            return '';
        }

        return $date;
    }

    private function normalizeTime(
        string $field,
        mixed $value,
        bool $required = false,
    ): string {
        $time = $this->validator->validate(
            name: $field,
            value: $value,
            required: $required,
            maxLength: 5,
        );

        if ($time === null) {
            return '';
        }

        $time = (string) $time;

        if (preg_match('/^(?:[01]\d|2[0-3]):[0-5]\d$/', $time) !== 1) {
            $this->validator->addError(
                $field,
                'Podaj poprawną godzinę.',
            );

            return '';
        }

        return $time;
    }

    private function normalizeLink(mixed $rawLink): array
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
            required: $hasUrl,
            maxLength: 80,
        );
        $url = $this->validator->validate(
            name: 'payload.link.url',
            value: $rawUrl,
            required: $hasLabel,
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
