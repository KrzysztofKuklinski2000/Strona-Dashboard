<?php
declare(strict_types=1);

namespace App\Mapper\Dashboard\News\Payload;

use App\Core\Validator;
use App\Mapper\Dashboard\Payload\OptionalLinkNormalizer;
use App\Mapper\Dashboard\Payload\PayloadNormalizerInterface;
use DateTimeImmutable;

final readonly class CompetitionResultsNormalizer implements PayloadNormalizerInterface
{
    private const MAX_RESULTS = 20;

    public function __construct(
        private Validator $validator,
        private OptionalLinkNormalizer $linkNormalizer,
    ) {
    }

    public function normalize(array $rawPayload, bool $requireCompleteData = true): array {
        $competitionDate = $this->normalizeDate(
            $rawPayload['competition_date'] ?? null, $requireCompleteData
        );

        $location = $this->validator->validate(
            name: 'payload.location',
            value: $rawPayload['location'] ?? null,
            required: $requireCompleteData,
            maxLength: 160
        );

        $description = $this->validator->validate(
            name: 'payload.description',
            value: $rawPayload['description'] ?? null,
            required: $requireCompleteData,
            maxLength: 1000,
        );

        $link = $this->linkNormalizer->normalize($rawPayload['link'] ?? [], $requireCompleteData);

        return [
            'competition_date' => $competitionDate,
            'location' => $location ?? '',
            'description' => $description ?? '',
            'results' => $this->normalizeResults($rawPayload['results'] ?? [], $requireCompleteData),
            'link' => $link,
        ];
    }

    private function normalizeResults(mixed $rawResults, bool $requireCompleteData): array
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
                required: $requireCompleteData,
                maxLength: 30,
            );

            $competitor = $this->validator->validate(
                name: "payload.results.$index.competitor",
                value: $rawCompetitor,
                required: $requireCompleteData,
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

        if ($results === [] && $requireCompleteData) {
            $this->validator->addError(
                'payload.results',
                'Dodaj przynajmniej jeden wynik.',
            );
        }

        return $results;
    }



    private function normalizeDate(mixed $rawDate, bool $requireCompleteData): string
    {
        $date = $this->validator->validate(
            name: 'payload.competition_date',
            value: $rawDate,
            required: $requireCompleteData,
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

}
