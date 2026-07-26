<?php

namespace App\Mapper\Dashboard;

use App\Core\Request;
use App\Core\Validator;
use App\DTO\Dashboard\ContactDto;

readonly class ContactRequestMapper
{
    public function __construct(
        private Request $request,
        private Validator $validator
    )
    {
    }

    public function mapUpdate(): ContactDto
    {
        $data = [
            'email' => $this->validator->validate(
                name: 'email',
                value: $this->request->getFormParam('email'),
                required: true,
                maxLength: 100
            ),

            'phone' => $this->validator->validate(
                name: 'phone',
                value: $this->request->getFormParam('phone'),
                required: true,
                maxLength: 9
            ),

            'address' => $this->validator->validate(
                name: 'address',
                value: $this->request->getFormParam('address'),
                required: true,
            ),
        ];

        return ContactDto::fromArray($data);
    }
}