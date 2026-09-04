<?php
declare(strict_types=1);

namespace App\Mapper\Dashboard\News\Payload;

use App\Core\Validator;
use App\Mapper\Dashboard\Payload\PayloadNormalizerInterface;

final readonly class ArticleNormalizer implements PayloadNormalizerInterface
{
    public function __construct(private Validator $validator)
    {
    }

    public function normalize(array $rawPayload): array {
        $description = $this->validator->validate(
            name: 'payload.description',
            value: $rawPayload['description'] ?? null,
            required: true,
            maxLength: 1000,
        );

        return [
            'description' => $description === null ? '' : (string) $description,
        ];
    }
}