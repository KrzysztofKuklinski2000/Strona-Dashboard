<?php

declare(strict_types=1);

namespace App\Mapper\Dashboard;

use App\Core\Request;
use App\Core\Validator;
use App\DTO\Dashboard\CreateTimetableDto;
use App\DTO\Dashboard\PublishedDto;
use App\DTO\Dashboard\UpdateTimetableDto;

readonly class TimetableRequestMapper
{
    public function __construct(
        private Request                  $request,
        private Validator                $validator,
        private PublicationRequestMapper $publicationRequestMapper,
        private DeleteRequestMapper      $deleteRequestMapper,
    ) {
    }

    public function mapCreate(): CreateTimetableDto
    {
        $data = [
            'day' => $this->validator->validate(
                name: 'day',
                value: $this->request->getFormParam('day'),
                required: true,
                maxLength: 20
            ),

            'city' => $this->validator->validate(
                name: 'city',
                value: $this->request->getFormParam('city'),
                required: true,
                maxLength: 40
            ),

            'advancement_group' => $this->validator->validate(
                name: 'group',
                value: $this->request->getFormParam('group'),
                required: true,
                maxLength: 40
            ),

            'place' => $this->validator->validate(
                name: 'place',
                value: $this->request->getFormParam('place'),
                required: true,
                maxLength: 100
            ),

            'start' => $this->validator->validate(
                name: 'startTime',
                value: $this->request->getFormParam('startTime'),
                required: true,
            ),

            'end' => $this->validator->validate(
                name: 'endTime',
                value: $this->request->getFormParam('endTime'),
                required: true,
            ),

            'is_notify' => $this->request->getFormParam('is_notify')
        ];

        return CreateTimetableDto::fromArray($data);
    }

    public function mapUpdate(): UpdateTimetableDto
    {
        $data = [
            'id' => $this->validator->validate(
                name: 'id',
                value: $this->request->getFormParam('id'),
                required: true,
                type: 'int'
            ),

            'day' => $this->validator->validate(
                name: 'day',
                value: $this->request->getFormParam('day'),
                required: true,
                maxLength: 20
            ),

            'city' => $this->validator->validate(
                name: 'city',
                value: $this->request->getFormParam('city'),
                required: true,
                maxLength: 40
            ),

            'advancement_group' => $this->validator->validate(
                name: 'group',
                value: $this->request->getFormParam('group'),
                required: true,
                maxLength: 40
            ),

            'place' => $this->validator->validate(
                name: 'place',
                value: $this->request->getFormParam('place'),
                required: true,
                maxLength: 100
            ),

            'start' => $this->validator->validate(
                name: 'startTime',
                value: $this->request->getFormParam('startTime'),
                required: true,
            ),

            'end' => $this->validator->validate(
                name: 'endTime',
                value: $this->request->getFormParam('endTime'),
                required: true,
            ),

            'is_notify' => $this->request->getFormParam('is_notify')
        ];

        return UpdateTimetableDto::fromArray($data);
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
