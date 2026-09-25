<?php
declare(strict_types=1);

namespace App\Validator\Dashboard;

use App\Core\Validator;
use App\Mapper\Dashboard\Payload\PostPayloadNormalizer;
use JsonException;

final readonly class PostPublicationValidator
{
    public function __construct(
        private Validator $validator,
        private PostPayloadNormalizer $payloadNormalizer,
        private array $typesRequiringImage = [],
    )
    {
    }

    public function validate(string $title, string $type, ?string $payload): void {
        $this->validator->validate(
            name: 'postTitle',
            value: $title,
            required: true,
            maxLength: 60,
        );

        if($payload === null) {
            $this->validator->addError(
                'payload',
                'Nie udało się przygotować danych posta.',
            );

            return;
        }

        try {
            $payload = json_decode($payload,true, 512, JSON_THROW_ON_ERROR);
        }catch (JsonException $e){
            $this->validator->addError(
                'payload',
                'Nie udało się przygotować danych posta.',
            );
            return;
        }

        if (!is_array($payload)) {
            $this->validator->addError(
                'payload',
                'Dane posta mają nieprawidłową strukturę.',
            );

            return;
        }

        if(in_array($type, $this->typesRequiringImage, true)) {
            $image = $payload['image'] ?? null;

            $imageSrc = is_array($image)
                ? ($image['src'] ?? null)
                : null;

            if (!is_string($imageSrc) || trim($imageSrc) === '') {
                $this->validator->addError(
                    'postImage',
                    'Obraz jest wymagany dla tego typu posta.',
                );
            }
        }

        $this->payloadNormalizer->normalize($type, $payload, requireCompleteData: true);
    }
}