<?php

declare(strict_types=1);

namespace App\Mapper\Dashboard\Homepage;

use App\Content\HomepagePostTypes;
use App\Core\Config;
use App\Core\Request;
use App\Core\Validator;
use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\Dashboard\CreateHomepagePostDto;
use App\DTO\Dashboard\PublishedDto;
use App\DTO\Dashboard\UpdateHomepagePostDto;
use App\Mapper\Dashboard\ChangePositionRequestMapper;
use App\Mapper\Dashboard\DeleteRequestMapper;
use App\Mapper\Dashboard\PublicationRequestMapper;

readonly class HomepagePostRequestMapper
{
    public function __construct(
        private Request                       $request,
        private Validator                     $validator,
        private Config                        $config,
        private HomepagePostPayloadNormalizer $payloadNormalizer,
        private ChangePositionRequestMapper   $changePositionRequestMapper,
        private PublicationRequestMapper      $publicationRequestMapper,
        private DeleteRequestMapper           $deleteRequestMapper,
    ) {
    }

    public function mapCreate(): CreateHomepagePostDto
    {

        $type = $this->validator->validate(
            name: 'postType',
            value: $this->request->getFormParam('postType'),
            required: true,
        );

        if (!HomepagePostTypes::isAllowed((string)$type)) {
            $type = HomepagePostTypes::SIMPLE_TEXT;
        }

        $imageFile = null;

        if ($type === HomepagePostTypes::IMAGE_TEXT_LIST) {
            $imageFile = $this->validator->validateFile(
                field: 'postImage',
                file: $this->request->getFile('postImage'),
                maxSize: $this->config->getMaxUploadSize()
            ) ?? null;
        }

        $rawPayload = $this->request->getFormParam('payload') ?? [];

        if (!is_array($rawPayload)) {
            $rawPayload = [];
        }

        $payload = $this->payloadNormalizer->normalize($type, $rawPayload);

        $data = [


            'title' => $this->validator->validate(
                name: 'postTitle',
                value: $this->request->getFormParam('postTitle'),
                required: true,
                maxLength: 60
            ),

            'created' => date('Y-m-d'),

            'updated' => date('Y-m-d'),

            'status' => 1,

            'type' => $type,

            'payload' => $payload,

            'imageFile' => $imageFile
        ];

        return CreateHomepagePostDto::fromArray($data);
    }

    public function mapUpdate(): UpdateHomepagePostDto
    {
        $type = $this->validator->validate(
            name: 'postType',
            value: $this->request->getFormParam('postType'),
            required: true,
        );

        if (!HomepagePostTypes::isAllowed((string)$type)) {
            $type = HomepagePostTypes::SIMPLE_TEXT;
        }

        $rawPayload = $this->request->getFormParam('payload') ?? [];

        if (!is_array($rawPayload)) {
            $rawPayload = [];
        }

        $imageFile = null;

        if ($type === HomepagePostTypes::IMAGE_TEXT_LIST) {
            $rawImage = is_array($rawPayload['image'] ?? null)
                ? $rawPayload['image']
                : [];

            $hasSavedImage = !empty($rawImage['src']);

            $imageFile = $this->validator->validateFile(
                field: 'postImage',
                file: $this->request->getFile('postImage'),
                maxSize: $this->config->getMaxUploadSize(),
                required: !$hasSavedImage,
            );
        }

        $payload = $this->payloadNormalizer->normalize($type, $rawPayload);

        $data = [
            'id' => $this->validator->validate(
                name: 'postId',
                value: $this->request->getFormParam('postId'),
                required: true,
                type: 'int'
            ),

            'title' => $this->validator->validate(
                name: 'postTitle',
                value: $this->request->getFormParam('postTitle'),
                required: true,
                maxLength: 60
            ),

            'updated' => date('Y-m-d'),

            'type' => $type,

            'payload' => $payload,

            'imageFile' => $imageFile

        ];

        return UpdateHomepagePostDto::fromArray($data);
    }

    public function mapChangePosition(): ChangePositionDto
    {
        return $this->changePositionRequestMapper->map();
    }

    public function mapPublication(): PublishedDto
    {
        return $this->publicationRequestMapper->map();
    }

    public function mapDelete(): ?int
    {
        return $this->deleteRequestMapper->map();
    }
}
