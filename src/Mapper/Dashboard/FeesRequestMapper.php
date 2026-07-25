<?php

namespace App\Mapper\Dashboard;

use App\Core\Request;
use App\Core\Validator;
use App\DTO\Dashboard\FeesDto;

readonly class FeesRequestMapper
{
    public function __construct(
        private Request $request,
        private Validator $validator
    )
    {
    }

    public function mapUpdate(): FeesDto
    {
        $data = [
            'reduced_contribution_1_month' => $this->validator->validate(
                name: 'n1',
                value: $this->request->getFormParam('n1'),
                required: true,
                type: 'int'
            ),

            'reduced_contribution_2_month' => $this->validator->validate(
                name: 'n2',
                value: $this->request->getFormParam('n2'),
                required: true,
                type: 'int'
            ),

            'family_contribution_month' => $this->validator->validate(
                name: 'n3',
                value: $this->request->getFormParam('n3'),
                required: true,
                type: 'int'
            ),

            'reduced_contribution_1_year' => $this->validator->validate(
                name: 'n6',
                value: $this->request->getFormParam('n6'),
                required: true,
                type: 'int'
            ),

            'reduced_contribution_2_year' => $this->validator->validate(
                name: 'n7',
                value: $this->request->getFormParam('n7'),
                required: true,
                type: 'int'
            ),

            'family_contribution_year' => $this->validator->validate(
                name: 'n8',
                value: $this->request->getFormParam('n8'),
                required: true,
                type: 'int'
            ),

            'extra_information' => $this->validator->validate(
                name: 'n10',
                value: $this->request->getFormParam('n10'),
                required: true,
            ),

            'fees_information' => $this->validator->validate(
                name: 'n11',
                value: $this->request->getFormParam('n11'),
                required: true,
            ),
        ];

        return FeesDto::fromArray($data);
    }
}