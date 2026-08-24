<?php

declare(strict_types=1);

namespace App\Mapper\Dashboard\Homepage\Payload;

use App\Core\Validator;
use App\Mapper\Dashboard\Payload\PayloadNormalizerInterface;

final readonly class ModuleFeedNormalizer implements PayloadNormalizerInterface
{
    private const MIN_POSTS = 1;
    private const MAX_POSTS = 12;

    public function __construct(private Validator $validator)
    {
    }

    public function normalize(array $rawPayload): array
    {
        $module = $this->validator->validate(
            name: 'payload.module',
            value: $rawPayload['module'] ?? null,
            required: true,
        );

        if($module !== null && $module !== 'news') {
            $this->validator->addError(
                'payload.module',
                'Moduł nie jest obsługiwany'
            );
        }

        $limit = $this->validator->validate(
            name: 'payload.limit',
            value: $rawPayload['limit'] ?? null,
            required: true,
            type: 'int'
        );

        if($limit !== null && ($limit < self::MIN_POSTS || $limit > self::MAX_POSTS)) {
            $this->validator->addError(
                'payload.limit',
                'Limit nie mieści się w przedziale od 1-12'
            );
        }

        return [
            'module' => $module ?? '',
            'limit' => $limit ?? 0,
        ];
    }
}