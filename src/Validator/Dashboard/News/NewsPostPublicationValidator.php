<?php
declare(strict_types=1);

namespace App\Validator\Dashboard\News;

use App\Core\Validator;
use App\DTO\Dashboard\News\NewsDto;
use App\Mapper\Dashboard\Payload\PostPayloadNormalizer;
use JsonException;

final readonly class NewsPostPublicationValidator
{
    public function __construct(
        private Validator $validator,
        private PostPayloadNormalizer $payloadNormalizer
    )
    {
    }

    public function validate(NewsDto $post): void  {
        $this->validator->validate(
            name: 'postTitle',
            value: $post->title,
            required: true,
            maxLength: 60,
        );

        try {
            $payload = json_decode($post->payload,true, 512, JSON_THROW_ON_ERROR);
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

        $this->payloadNormalizer->normalize(
            $post->type,
            $payload,
            requireCompleteData: true,
        );
    }
}