<?php

declare(strict_types=1);

namespace App\Mapper\Dashboard\News;

use App\Content\NewsPostTypes;
use App\Core\Config;
use App\Core\Request;
use App\Core\Validator;
use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\Dashboard\News\CreateNewsDto;
use App\DTO\Dashboard\News\UpdateNewsDto;
use App\DTO\Dashboard\PublishedDto;
use App\Mapper\Dashboard\ChangePositionRequestMapper;
use App\Mapper\Dashboard\DeleteRequestMapper;
use App\Mapper\Dashboard\Payload\PostPayloadNormalizer;
use App\Mapper\Dashboard\PublicationRequestMapper;

readonly class NewsPostRequestMapper
{
    public function __construct(
        private Request                     $request,
        private Validator                   $validator,
        private Config                      $config,
        private PostPayloadNormalizer       $normalizer,
        private ChangePositionRequestMapper $changePositionRequestMapper,
        private PublicationRequestMapper    $publicationRequestMapper,
        private DeleteRequestMapper         $deleteRequestMapper,
    )
    {
    }

    public function mapCreate(): CreateNewsDto
    {
        $currentDate = date('Y-m-d');
        $postType = $this->resolvePostType();
        $rawPayload = $this->getRawPayload();
        $payload = $this->normalizer->normalize($postType, $rawPayload);

        $data = [
            'title' => $this->validator->validate(
                name: 'postTitle',
                value: $this->request->getFormParam('postTitle'),
                required: true,
                maxLength: 60,
            ),
            'created' => $currentDate,
            'updated' => $currentDate,
            'status' => 0,
            'type' => $postType,
            'payload' => $payload,
            'imageFile' => $this->getImage($postType)
        ];

        return CreateNewsDto::fromArray($data);
    }

    public function mapUpdate(): UpdateNewsDto
    {
        $postType = $this->resolvePostType();
        $rawPayload = $this->getRawPayload();
        $payload = $this->normalizer->normalize($postType, $rawPayload);

        $data = [
            'id' => $this->validator->validate(
                name: 'postId',
                value: $this->request->getFormParam('postId'),
                required: true,
                type: 'int',
            ),
            'title' => $this->validator->validate(
                name: 'postTitle',
                value: $this->request->getFormParam('postTitle'),
                required: true,
                maxLength: 60,
            ),
            'updated' => date('Y-m-d'),
            'type' => $postType,
            'payload' => $payload,
            'imageFile' => $this->getImage($postType),
            'removeImage' => $this->request->getFormParam('removeImage') === '1',
        ];

        return UpdateNewsDto::fromArray($data);
    }

    public function mapPublication(): PublishedDto
    {
        return $this->publicationRequestMapper->map();
    }

    public function mapChangePosition(): ChangePositionDto
    {
        return $this->changePositionRequestMapper->map();
    }

    public function mapDelete(): ?int
    {
        return $this->deleteRequestMapper->map();
    }

    private function resolvePostType(): string
    {

        $postType = $this->validator->validate(
            name: 'postType',
            value: $this->request->getFormParam('postType'),
            required: true,
        );

        if (!NewsPostTypes::isAllowed((string)$postType)) {
            return NewsPostTypes::ARTICLE;
        }

        return $postType;
    }

    private function getRawPayload(): array
    {
        $rawPayload = $this->request->getFormParam('payload') ?? [];

        return is_array($rawPayload) ? $rawPayload : [];
    }

    private function getImage(string $type): ?array {
        if(NewsPostTypes::supportsImage($type)) {
            return $this->validator->validateFile(
                field: 'postImage',
                file: $this->request->getFile('postImage'),
                maxSize: $this->config->getMaxUploadSize(),
                required: false,
            );
        }

        return null;
    }
}
