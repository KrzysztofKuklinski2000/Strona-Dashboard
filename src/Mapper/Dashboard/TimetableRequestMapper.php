<?php

namespace App\Mapper\Dashboard;

use App\Core\Request;
use App\Core\Validator;
use App\DTO\Dashboard\CreateTimetableDto;
use App\DTO\Dashboard\PublishedTimetableDto;
use App\DTO\Dashboard\UpdateTimetableDto;
use App\DTO\DataTransferObjectInterface;

readonly class TimetableRequestMapper
{
    public function __construct(
        private Request $request,
        private Validator $validator,
    )
    {
    }

    public function mapCreate(): DataTransferObjectInterface
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

    public function mapUpdate(): DataTransferObjectInterface
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

    public function mapPublish(): DataTransferObjectInterface
    {
        $data = [
            'published' => $this->validator->validate(
                name: 'postPublished',
                value: $this->request->getFormParam('postPublished'),
                required: true
            ),

            'id' => $this->validator->validate(
                name: 'postId',
                value: $this->request->getFormParam('postId'),
                required: true
            ),

            'is_notify' => $this->request->getFormParam('is_notify')
        ];

        return PublishedTimetableDto::fromArray($data);
    }

}