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
        private Request                     $request,
        private Validator                   $validator,
        private ChangePositionRequestMapper $changePositionRequestMapper,
        private PublicationRequestMapper    $publicationRequestMapper,
        private DeleteRequestMapper         $deleteRequestMapper,
    ) {
    }

    public function mapCreate(): CreateImportantPostDto
    {
        $currentDate = date('Y-m-d');

        $data = [
            ...$this->mapCommonFields(),
            'created' => $currentDate,
            'updated' => $currentDate,
            'status' => 1,
        ];

        return CreateImportantPostDto::fromArray($data);
    }

    public function mapUpdate(): UpdateImportantPostDto
    {
        $data = [
            'id' => $this->validator->validate(
                name: 'postId',
                value: $this->request->getFormParam('postId'),
                required: true,
                type: 'int',
            ),
            'updated' => date('Y-m-d'),
            ...$this->mapCommonFields(),
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

    private function mapCommonFields(): array {
        return [
            'title' => $this->validator->validate(
                name: 'postTitle',
                value: $this->request->getFormParam('postTitle'),
                required: true,
                maxLength: 60,
            ),
            'description' => $this->validator->validate(
                name: 'postDescription',
                value: $this->request->getFormParam('postDescription'),
                required: true,
                maxLength: 1000,
            ),
        ];
    }
}
