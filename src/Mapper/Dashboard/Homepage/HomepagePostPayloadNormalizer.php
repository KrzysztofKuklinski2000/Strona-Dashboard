<?php
declare(strict_types=1);

namespace App\Mapper\Dashboard\Homepage;

use App\Core\Validator;
use App\Mapper\Dashboard\Payload\PayloadNormalizerInterface;

final readonly class HomepagePostPayloadNormalizer
{
    /**
     * @param array<string, PayloadNormalizerInterface> $normalizers
     */
    public function __construct(
        private Validator $validator,
        private array     $normalizers
    )
    {
    }

    public function normalize(string $type, array $rawPayload): ?string
    {

        $normalizer = $this->normalizers[$type] ?? null;

        if (!$normalizer instanceof PayloadNormalizerInterface) {
            $this->validator->addError(
                'postType',
                'Brak obsługi wybranego typu posta.',
            );

            return null;
        }

        $payload = $normalizer->normalize($rawPayload);
        $json = json_encode($payload, JSON_UNESCAPED_UNICODE);

        if ($json === false) {
            $this->validator->addError(
                'payload',
                'Nie udało się przygotować danych posta.',
            );

            return '{}';
        }

        return $json;
    }
}