<?php
declare(strict_types=1);

namespace App\Mapper\Dashboard;

use App\Core\Request;
use App\Core\Validator;
use App\DTO\Dashboard\ChangePositionDto;

readonly class ChangePositionRequestMapper
{
    public function __construct(
        private Request $request,
        private Validator $validator
    )
    {
    }

    public function map(): ChangePositionDto
    {

        $direction = $this->validator->validate(
            name: 'dir',
            value: $this->request->getFormParam('dir'),
            required: true
        );

        $data = [
            'id' => $this->validator->validate(
                name: 'id',
                value: $this->request->getFormParam('id'),
                required: true,
                type: 'int'
            ),
        ];


        if ($direction !== null && !in_array($direction, ['up', 'down'], true)) {
            $this->validator->addError(
                'dir',
                'Nieprawidłowy kierunek zmiany pozycji.'
            );
        }

        $data['dir'] = (string) $direction;

        return ChangePositionDto::fromArray($data);
    }
}