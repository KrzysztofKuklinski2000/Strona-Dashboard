<?php

namespace App\Mapper\Dashboard;

use App\Core\Request;
use App\Core\Validator;
use App\DTO\Dashboard\CreateSubscriberDto;
use App\DTO\Dashboard\UpdateSubscriberDto;

readonly class SubscriberRequestMapper
{

    public function __construct(
        private Request $request,
        private Validator $validator
    )
    {
    }

    public function mapCreate(): CreateSubscriberDto
    {
        $data = [
            'email' => $this->validator->validate(
                name: 'email',
                value: $this->request->getFormParam('email'),
                required: true,
                type: 'email',
                maxLength: 100
            )
        ];

        return CreateSubscriberDto::fromArray($data);
    }

    public function mapUpdate(): UpdateSubscriberDto
    {
        $data = [

            'id' => $this->validator->validate(
                name: 'id',
                value: $this->request->getFormParam('id'),
                required: true,
                type: 'int'
            ),

            'email' => $this->validator->validate(
                name: 'email',
                value: $this->request->getFormParam('email'),
                required: true,
                type: 'email',
                maxLength: 100
            ),

            'is_active' => (int)$this->validator->validate(
                name: 'is_active',
                value: $this->request->getFormParam('is_active')
            )
        ];
        return UpdateSubscriberDto::fromArray($data);
    }
}