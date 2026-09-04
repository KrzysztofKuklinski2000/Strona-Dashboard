<?php

declare(strict_types=1);

namespace App\Mapper\Dashboard\News\Payload;

use App\Core\Validator;
use App\Mapper\Dashboard\Payload\PayloadNormalizerInterface;

final readonly class EventNormalizer implements PayloadNormalizerInterface
{
    public function __construct(private Validator $validator)
    {
    }

    public function normalize(array $rawPayload): array
    {

        $eventData = $this->validator->validate(
            name: 'payload.event_date',
            value: $rawPayload['event_date'] ?? null,
            required: true,
        );

        $eventStartTime = $this->validator->validate(
            name: 'payload.start_time',
            value: $rawPayload['start_time'] ?? null,
            required: true,
        );

        $eventEndTime = $this->validator->validate(
            name: 'payload.end_time',
            value: $rawPayload['end_time'] ?? null,
        );

        $location = $this->validator->validate(
            name: 'payload.location',
            value: $rawPayload['location'] ?? null,
            required: true,
            maxLength: 160
        );

        $linkLabel = $this->validator->validate(
            name: 'payload.link.label',
            value: $rawPayload['link']['label'] ?? null,
            maxLength: 80
        );

        $linkUrl = $this->validator->validate(
            name: 'payload.link.url',
            value: $rawPayload['link']['url'] ?? null,
            maxLength: 255
        );

        $description = $this->validator->validate(
            name: 'payload.description',
            value: $rawPayload['description'] ?? null,
            required: true,
            maxLength: 1000,
        );

        return [
            'event_date' => $eventData ?? '',
            'start_time' => $eventStartTime ?? '',
            'end_time' => $eventEndTime ?? '',
            'description' => $description ?? '',
            'location' => $location ?? '',
            'link' => [
                'label' => $linkLabel ?? '',
                'url' => $linkUrl ?? '',
            ],
        ];
    }
}