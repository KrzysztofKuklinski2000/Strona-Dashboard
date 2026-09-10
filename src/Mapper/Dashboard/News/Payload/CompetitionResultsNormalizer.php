<?php
declare(strict_types=1);

namespace App\Mapper\Dashboard\News\Payload;

use App\Core\Validator;
use App\Mapper\Dashboard\Payload\PayloadNormalizerInterface;
use DateTimeImmutable;

final readonly class CompetitionResultsNormalizer implements PayloadNormalizerInterface
{
    private const MAX_RESULTS = 20;

    public function __construct(private Validator $validator)
    {
    }

    public function normalize(array $rawPayload): array {
        $competitionDate = $this->normalizeDate($rawPayload['competition_date'] ?? null);

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

        $link = $this->normalizeLink($rawPayload['link'] ?? []);

        return [
            'competition_date' => $competitionDate,
            'location' => $location ?? '',
            'description' => $description ?? '',
            'results' => $this->normalizeResults($rawPayload['results'] ?? []),
            'link' => $link,
        ];
    }

    private function normalizeResults(mixed $rawResults): array
    {
        if (!is_array($rawResults)) {
            $this->validator->addError(
                'payload.results',
                'Wyniki muszą być przesłane jako lista.',
            );

            return [];
        }

        if (count($rawResults) > self::MAX_RESULTS) {
            $this->validator->addError(
                'payload.results',
                'Możesz dodać maksymalnie ' . self::MAX_RESULTS . ' wyników.',
            );

            $rawResults = array_slice($rawResults, 0, self::MAX_RESULTS);
        }

        $results = [];

        foreach ($rawResults as $index => $rawResult) {
            if (!is_array($rawResult)) {
                $this->validator->addError(
                    "payload.results.$index.competitor",
                    'Nieprawidłowe dane wyniku.',
                );

                continue;
            }

            $rawPlace = $rawResult['place'] ?? null;
            $rawCompetitor = $rawResult['competitor'] ?? null;
            $rawCategory = $rawResult['category'] ?? null;

            if (
                ($rawPlace === null || $rawPlace === '')
                && ($rawCompetitor === null || $rawCompetitor === '')
                && ($rawCategory === null || $rawCategory === '')
            ) {
                continue;
            }

            $place = $this->validator->validate(
                name: "payload.results.$index.place",
                value: $rawPlace,
                required: true,
                maxLength: 30,
            );

            $competitor = $this->validator->validate(
                name: "payload.results.$index.competitor",
                value: $rawCompetitor,
                required: true,
                maxLength: 120,
            );

            $category = $this->validator->validate(
                name: "payload.results.$index.category",
                value: $rawCategory,
                maxLength: 120,
            );

            $results[] = [
                'place' => $place ?? '',
                'competitor' => $competitor ?? '',
                'category' => $category ?? '',
            ];
        }

        if ($results === []) {
            $this->validator->addError(
                'payload.results',
                'Dodaj przynajmniej jeden wynik.',
            );
        }

        return $results;
    }



    private function normalizeDate(mixed $rawDate): string
    {
        $date = $this->validator->validate(
            name: 'payload.competition_date',
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
                'payload.competition_date',
                'Podaj poprawną datę zawodów.',
            );

            return '';
        }

        return $date;
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