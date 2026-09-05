<?php

declare(strict_types=1);

namespace App\Mapper\Dashboard;

use App\Content\NewsPostTypes;
use App\Core\Request;
use App\Core\Validator;
use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\Dashboard\CreateNewsDto;
use App\DTO\Dashboard\PublishedDto;
use App\DTO\Dashboard\UpdateNewsDto;
use App\Mapper\Dashboard\News\NewsPostPayloadNormalizer;

readonly class NewsRequestMapper
{
    public function __construct(
        private Request                     $request,
        private Validator                   $validator,
        private NewsPostPayloadNormalizer   $normalizer,
        private ChangePositionRequestMapper $changePositionRequestMapper,
        private PublicationRequestMapper    $publicationRequestMapper,
        private DeleteRequestMapper         $deleteRequestMapper,
    )
    {
    }

    public function mapCreate(): CreateNewsDto
    {
        $currentDate = date('Y-m-d');

        $postType = $this->validator->validate(
            name: 'postType',
            value: $this->request->getFormParam('postType'),
            required: true,
        );

        if(!NewsPostTypes::isAllowed((string) $postType)) {
            $postType = NewsPostTypes::ARTICLE;
        }

        $rawPayload = $this->request->getFormParam('payload') ?? [];

        if(!is_array($rawPayload)) {
            $rawPayload = [];
        }

        $payload = $this->normalizer->normalize($postType, $rawPayload);

        $data = [
            'title' => $this->validator->validate(
                name: 'postTitle',
                value: $this->request->getFormParam('postTitle'),
                required: true,
                maxLength: 60,
            ),
            'description' => '',
            'created' => $currentDate,
            'updated' => $currentDate,
            'status' => 1,
            'type' => $postType,
            'payload' => $payload,
        ];

        return CreateNewsDto::fromArray($data);
    }

    public function mapUpdate(): UpdateNewsDto
    {
        $postType = $this->validator->validate(
            name: 'postType',
            value: $this->request->getFormParam('postType'),
            required: true,
        );

        if(!NewsPostTypes::isAllowed((string) $postType)) {
            $postType = NewsPostTypes::ARTICLE;
        }

        $rawPayload = $this->request->getFormParam('payload') ?? [];

        if(!is_array($rawPayload)) {
            $rawPayload = [];
        }

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
            'description' => '',
            'updated' => date('Y-m-d'),
            'type' => $postType,
            'payload' => $payload,
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
}
