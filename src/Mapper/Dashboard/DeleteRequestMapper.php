<?php
declare(strict_types=1);

namespace App\Mapper\Dashboard;

use App\Core\Request;
use App\Core\Validator;

readonly class DeleteRequestMapper
{
    public function __construct(
        private Request   $request,
        private Validator $validator
    )
    {
    }


    public function map(): ?int {
        $id = $this->validator->validate(
            name: 'id',
            value: $this->request->getRouteParam('id'),
            required: true,
            type:'int',
        );

        if(!is_int($id)) {
            return null;
        }

        if($id < 1) {
            $this->validator->addError(
                'id',
                'Nieprawidłowy identyfikator wpisu.'
            );
            return null;
        }

        return $id;
    }
}