<?php
declare(strict_types=1);

namespace App\Mapper\Dashboard\News\Payload;

use App\Core\Validator;
use App\Mapper\Dashboard\Payload\PayloadNormalizerInterface;

readonly class FundingNormalizer implements PayloadNormalizerInterface
{
    public function __construct(private Validator $validator)
    {
    }

    public function normalize(array $rawPayload): array
    {
        $fundingSource = $this->validator->validate(
            name: 'payload.funding_source',
            value: $rawPayload['funding_source'] ?? null,
            required: true,
            maxLength: 160
        );

        $amount = $this->validator->validate(
            name: 'payload.amount',
            value: $rawPayload['amount'] ?? null,
            maxLength: 80
        );

        $description = $this->validator->validate(
            name: 'payload.description',
            value: $rawPayload['description'] ?? null,
            required: true,
            maxLength: 1000,
        );

        return [
            'funding_source' => $fundingSource ?? '',
            'amount' => $amount ?? '',
            'description' => $description ?? '',
        ];
    }
}
