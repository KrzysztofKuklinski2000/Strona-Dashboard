<?php
declare(strict_types=1);

namespace App\Validator\Dashboard\Homepage;

use App\Content\HomepagePostTypes;
use App\Core\Validator;
use App\DTO\Dashboard\Homepage\HomepagePostDto;
use App\Mapper\Dashboard\Payload\PostPayloadNormalizer;
use JsonException;

final readonly class HomepagePostPublicationValidator
{
    public function __construct(
        private Validator $validator,
        private PostPayloadNormalizer $payloadNormalizer
    )
    {
    }

    public function validate(HomepagePostDto $post): void  {
        $this->validator->validate(
            name: 'postTitle',
            value: $post->title,
            required: true,
            maxLength: 60,
        );

        if($post->payload === null) {
            $this->validator->addError(
                'payload',
                'Nie udało się przygotować danych posta.',
            );

            return;
        }

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

        if($post->type === HomepagePostTypes::IMAGE_TEXT_LIST) {
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

        $this->payloadNormalizer->normalize(
            $post->type,
            $payload,
            requireCompleteData: true,
        );
    }
}