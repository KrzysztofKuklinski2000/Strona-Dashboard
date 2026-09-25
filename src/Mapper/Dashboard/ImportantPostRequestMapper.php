<?php

declare(strict_types=1);

namespace App\Mapper\Dashboard;

use App\Core\Request;
use App\Core\Validator;
use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\Dashboard\ImportantPosts\CreateImportantPostDto;
use App\DTO\Dashboard\ImportantPosts\UpdateImportantPostDto;
use App\DTO\Dashboard\PublishedDto;

readonly class ImportantPostRequestMapper
{
    public function __construct(
        private Request                       $request,
        private Validator                     $validator,
        private ChangePositionRequestMapper   $changePositionRequestMapper,
        private PublicationRequestMapper      $publicationRequestMapper,
        private DeleteRequestMapper           $deleteRequestMapper,
        private SubmissionActionRequestMapper $submissionActionRequestMapper,
    )
    {
    }

    public function mapCreate(): CreateImportantPostDto
    {
        $requireCompleteData = $this->submissionActionRequestMapper->shouldPublish();
        $status = $requireCompleteData ? 1 : 0;

        $currentDate = date('Y-m-d');

        $data = [
            ...$this->mapCommonFields($requireCompleteData),
            'created' => $currentDate,
            'updated' => $currentDate,
            'status' => $status,
        ];

        return CreateImportantPostDto::fromArray($data);
    }

    public function mapUpdate(): UpdateImportantPostDto
    {
        $requireCompleteData = $this->submissionActionRequestMapper->shouldPublish();
        $status = $requireCompleteData ? 1 : 0;

        $data = [
            'id' => $this->validator->validate(
                name: 'postId',
                value: $this->request->getRouteParam('id'),
                required: true,
                type: 'int',
            ),
            'updated' => date('Y-m-d'),
            'status' => $status,
            ...$this->mapCommonFields($requireCompleteData),
        ];

        return UpdateImportantPostDto::fromArray($data);
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

    private function mapCommonFields(bool $requireCompleteData): array
    {
        return [
            'title' => $this->validator->validate(
                name: 'postTitle',
                value: $this->request->getFormParam('postTitle'),
                required: $requireCompleteData,
                maxLength: 60,
            ),
            'description' => $this->validator->validate(
                name: 'postDescription',
                value: $this->request->getFormParam('postDescription'),
                required: $requireCompleteData,
                maxLength: 1000,
            ),
        ];
    }
}
