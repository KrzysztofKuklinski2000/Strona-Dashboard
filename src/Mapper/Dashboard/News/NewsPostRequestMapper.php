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
use App\Mapper\Dashboard\SubmissionActionRequestMapper;

readonly class NewsPostRequestMapper
{
    public function __construct(
        private Request                       $request,
        private Validator                     $validator,
        private Config                        $config,
        private PostPayloadNormalizer         $normalizer,
        private ChangePositionRequestMapper   $changePositionRequestMapper,
        private PublicationRequestMapper      $publicationRequestMapper,
        private DeleteRequestMapper           $deleteRequestMapper,
        private SubmissionActionRequestMapper $submissionActionRequestMapper,
    )
    {
    }

    public function mapCreate(): CreateNewsDto
    {
        $requireCompleteData =$this->submissionActionRequestMapper->shouldPublish();
        $status = $requireCompleteData ? 1 : 0;

        $currentDate = date('Y-m-d');
        $postType = $this->resolvePostType();
        $rawPayload = $this->getRawPayload();
        $payload = $this->normalizer->normalize($postType, $rawPayload, $requireCompleteData);

        $data = [
            'title' => $this->validator->validate(
                name: 'postTitle',
                value: $this->request->getFormParam('postTitle'),
                required: $requireCompleteData,
                maxLength: 60,
            ),
            'created' => $currentDate,
            'updated' => $currentDate,
            'status' => $status,
            'type' => $postType,
            'payload' => $payload,
            'imageFile' => $this->getImage($postType)
        ];

        return CreateNewsDto::fromArray($data);
    }

    public function mapUpdate(): UpdateNewsDto
    {
        $requireCompleteData =$this->submissionActionRequestMapper->shouldPublish();
        $status = $requireCompleteData ? 1 : 0;

        $postType = $this->resolvePostType();
        $rawPayload = $this->getRawPayload();
        $payload = $this->normalizer->normalize($postType, $rawPayload, $requireCompleteData);

        $data = [
            'id' => $this->validator->validate(
                name: 'postId',
                value: $this->request->getRouteParam('id'),
                required: true,
                type: 'int',
            ),
            'title' => $this->validator->validate(
                name: 'postTitle',
                value: $this->request->getFormParam('postTitle'),
                required: $requireCompleteData,
                maxLength: 60,
            ),
            'updated' => date('Y-m-d'),
            'status' => $status,
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

    private function getImage(string $type): ?array
    {
        if (NewsPostTypes::supportsImage($type)) {
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
