<?php
declare(strict_types=1);

namespace App\Mapper\Dashboard\MainPage\Payload;

use App\Core\Validator;
use App\Mapper\Dashboard\Payload\PayloadNormalizerInterface;

final readonly class SimpleTextNormalizer implements PayloadNormalizerInterface
{

    public function __construct(private Validator $validator)
    {
    }

    public function normalize(array $rawPayload): array
    {
        $description = $this->validator->validate(
            name: 'payload.description',
            value: $rawPayload['description'] ?? null,
            required: true,
            minLength: 20,
            maxLength: 1000,
        );

        return [
            'description' => $description === null ? '' : (string) $description,
        ];
    }
}