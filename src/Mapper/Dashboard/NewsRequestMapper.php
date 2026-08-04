<?php

declare(strict_types=1);

namespace App\Mapper\Dashboard;

use App\Core\Request;
use App\Core\Validator;
use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\Dashboard\CreateNewsDto;
use App\DTO\Dashboard\PublishedDto;
use App\DTO\Dashboard\UpdateNewsDto;

readonly class NewsRequestMapper
{
    public function __construct(
        private Request $request,
        private Validator $validator,
        private ChangePositionRequestMapper $changePositionRequestMapper,
        private PublicationRequestMapper $publicationRequestMapper,
    ) {
    }

    public function mapCreate(): CreateNewsDto
    {
        $currentDate = date('Y-m-d');

        $data = [
            'title' => $this->validator->validate(
                name: 'postTitle',
                value: $this->request->getFormParam('postTitle'),
                required: true,
                minLength: 10,
                maxLength: 60,
            ),
            'description' => $this->validator->validate(
                name: 'postDescription',
                value: $this->request->getFormParam('postDescription'),
                required: true,
                minLength: 20,
                maxLength: 1000,
            ),
            'created' => $currentDate,
            'updated' => $currentDate,
            'status' => 1,
        ];

        return CreateNewsDto::fromArray($data);
    }

    public function mapUpdate(): UpdateNewsDto
    {
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
                minLength: 10,
                maxLength: 60,
            ),
            'description' => $this->validator->validate(
                name: 'postDescription',
                value: $this->request->getFormParam('postDescription'),
                required: true,
                minLength: 20,
                maxLength: 1000,
            ),
            'updated' => date('Y-m-d'),
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
}
