<?php
declare(strict_types=1);

namespace App\Mapper\Dashboard;

use App\Core\Request;
use App\Core\Validator;

final readonly class SubmissionActionRequestMapper
{

    public function __construct(
        private Request   $request,
        private Validator $validator
    )
    {
    }

    public function shouldPublish(): bool
    {
        $submitAction = $this->validator->validate(
            name: 'submitAction',
            value: $this->request->getFormParam('submitAction'),
            required: true,
        );

        if ($submitAction === null) {
            return false;
        }


        if (!in_array($submitAction, ['draft', 'publish'], true)) {
            $this->validator->addError(
                'submitAction',
                'Nieprawidłowa akcja formularza.',
            );

            return false;
        }

        return $submitAction === 'publish';
    }
}