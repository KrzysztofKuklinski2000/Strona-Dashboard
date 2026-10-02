<?php

declare(strict_types=1);

namespace App\Mapper\Dashboard;

use App\Core\Request;
use App\Core\Validator;
use App\DTO\Dashboard\PublishedDto;
use App\DTO\Dashboard\Timetable\CreateTimetableDto;
use App\DTO\Dashboard\Timetable\UpdateTimetableDto;

readonly class TimetableRequestMapper
{
    public function __construct(
        private Request                  $request,
        private Validator                $validator,
        private PublicationRequestMapper $publicationRequestMapper,
        private DeleteRequestMapper      $deleteRequestMapper,
    )
    {
    }

    public function mapCreate(): CreateTimetableDto
    {
        return CreateTimetableDto::fromArray($this->mapCommonFields());
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
            ...$this->mapCommonFields(),
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

    private function mapCommonFields(): array
    {
        $locationId =  $this->validator->validate(
            name: 'location_id',
            value: $this->request->getFormParam('location_id'),
            required: true,
            type: 'int'
        );

        if($locationId <= 0){
            $this->validator->addError(
                'location_id',
                'Nie poprawna lokalizacja'
            );
        }

        return [
            'day' => $this->validator->validate(
                name: 'day',
                value: $this->request->getFormParam('day'),
                required: true,
                maxLength: 20
            ),

            'advancement_group' => $this->validator->validate(
                name: 'group',
                value: $this->request->getFormParam('group'),
                required: true,
                maxLength: 40
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

            'is_notify' => $this->request->getFormParam('is_notify'),

            'location_id' => $locationId,
        ];
    }
}
