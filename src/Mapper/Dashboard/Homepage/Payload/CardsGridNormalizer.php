<?php

declare(strict_types=1);

namespace App\Mapper\Dashboard\Homepage\Payload;

use App\Core\Validator;
use App\Mapper\Dashboard\Payload\PayloadNormalizerInterface;

final readonly class CardsGridNormalizer implements PayloadNormalizerInterface
{
    private const MAX_CARDS = 12;

    public function __construct(private Validator $validator)
    {
    }

    public function normalize(array $rawPayload): array
    {
        $rawCards = $rawPayload['cards'] ?? [];

        if (!is_array($rawCards)) {
            $this->validator->addError(
                'payload.cards',
                'Kafelki muszą być przesłane jako lista.'
            );
            $rawCards = [];
        }

        if ($rawCards === []) {
            $this->validator->addError(
                'payload.cards',
                'Dodaj przynajmniej jeden kafelek.'
            );
        }

        if (count($rawCards) > self::MAX_CARDS) {
            $this->validator->addError(
                'payload.cards',
                'Możesz dodać maksymalnie ' . self::MAX_CARDS . ' kafelków.'
            );

            $rawCards = array_slice($rawCards, 0, self::MAX_CARDS);
        }

        $cards = [];

        foreach ($rawCards as $index => $rawCard) {
            if (!is_array($rawCard)) {
                $this->validator->addError(
                    "payload.cards.$index",
                    'Nieprawidłowe dane kafelka.'
                );

                continue;
            }

            $icon = $this->validator->validate(
                name: "payload.cards.$index.icon",
                value: $rawCard['icon'] ?? null,
                maxLength: 80,
            );

            $title = $this->validator->validate(
                name: "payload.cards.$index.title",
                value: $rawCard['title'] ?? null,
                required: true,
                maxLength: 80,
            );

            $description = $this->validator->validate(
                name: "payload.cards.$index.description",
                value: $rawCard['description'] ?? null,
                required: true,
                maxLength: 500,
            );

            $cards[] = [
                'icon' => $icon === null ? '' : (string) $icon,
                'title' => $title === null ? '' : (string) $title,
                'description' => $description === null ? '' : (string) $description,
            ];
        }

        $eyebrow = $this->validator->validate(
            name: 'payload.eyebrow',
            value: $rawPayload['eyebrow'] ?? null,
            maxLength: 80,
        );

        return [
            'eyebrow' => $eyebrow === null ? '' : (string) $eyebrow,
            'cards' => $cards,
        ];
    }
}
