<?php

namespace App\Mapper\Dashboard;

use App\Core\Request;
use App\Core\Validator;
use App\DTO\Dashboard\CampDto;

readonly class CampRequestMapper
{
    public function __construct(
        private  Request $request,
        private  Validator $validator,
    )
    {
    }

    public function mapUpdate(): CampDto
    {
        $data = [
            'city' => $this->validator->validate(
                name: 'town',
                value: $this->request->getFormParam('town'),
                required: true,
                maxLength: 50
            ),

            'guesthouse' => $this->validator->validate(
                name: 'guesthouse',
                value: $this->request->getFormParam('guesthouse'),
                required: true,
                maxLength: 70
            ),

            'city_start' => $this->validator->validate(
                name: 'townStart',
                value: $this->request->getFormParam('townStart'),
                required: true,
                maxLength: 50
            ),

            'date_start' => $this->validator->validate(
                name: 'dateStart',
                value: $this->request->getFormParam('dateStart'),
                required: true
            ),

            'date_end' => $this->validator->validate(
                name: 'dateEnd',
                value: $this->request->getFormParam('dateEnd'),
                required: true
            ),

            'time_start' => $this->validator->validate(
                name: 'timeStart',
                value: $this->request->getFormParam('timeStart'),
                required: true
            ),

            'time_end' => $this->validator->validate(
                name: 'timeEnd',
                value: $this->request->getFormParam('timeEnd'),
                required: true
            ),

            'place' => $this->validator->validate(
                name: 'place',
                value: $this->request->getFormParam('place'),
                required: true,
                maxLength: 100
            ),

            'accommodation' => $this->validator->validate(
                name: 'accommodation',
                value: $this->request->getFormParam('accommodation'),
                required: true,
                maxLength: 500
            ),

            'meals' => $this->validator->validate(
                name: 'meals',
                value: $this->request->getFormParam('meals'),
                required: true,
                maxLength: 500
            ),

            'trips' => $this->validator->validate(
                name: 'trips',
                value: $this->request->getFormParam('trips'),
                required: true,
                maxLength: 500
            ),

            'staff' => $this->validator->validate(
                name: 'staff',
                value: $this->request->getFormParam('staff'),
                required: true,
                maxLength: 500
            ),

            'transport' => $this->validator->validate(
                name: 'transport',
                value: $this->request->getFormParam('transport'),
                required: true,
                maxLength: 500
            ),

            'training' => $this->validator->validate(
                name: 'training',
                value: $this->request->getFormParam('training'),
                required: true,
                maxLength: 500
            ),

            'insurance' => $this->validator->validate(
                name: 'insurance',
                value: $this->request->getFormParam('insurance'),
                required: true,
                maxLength: 500
            ),

            'cost' => $this->validator->validate(
                name: 'cost',
                value: $this->request->getFormParam('cost'),
                required: true,
                type: 'int'
            ),

            'advancePayment' => $this->validator->validate(
                name: 'advancePayment',
                value: $this->request->getFormParam('advancePayment'),
                required: true,
                type: 'int'
            ),

            'advanceDate' => $this->validator->validate(
                name: 'advanceDate',
                value: $this->request->getFormParam('advanceDate'),
                required: true,
            ),
        ];

        return CampDto::fromArray($data);
    }
}