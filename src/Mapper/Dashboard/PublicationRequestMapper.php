<?php

declare(strict_types=1);

namespace App\Mapper\Dashboard;

use App\Core\Request;
use App\Core\Validator;
use App\DTO\Dashboard\PublishedDto;

readonly class PublicationRequestMapper
{
    public function __construct(
        private Request $request,
        private Validator $validator,
    ) {
    }

    public function map(): PublishedDto
    {
        $id = $this->validator->validate(
            name: 'id',
            value: $this->request->getRouteParam('id'),
            required: true,
            type: 'int',
        );

        $published = $this->validator->validate(
            name: 'postPublished',
            value: $this->request->getFormParam('postPublished'),
            required: true,
            type: 'int',
        );

        if ($published !== null && !in_array($published, [0, 1], true)) {
            $this->validator->addError(
                'postPublished',
                'Nieprawidłowy status publikacji.',
            );
        }

        return PublishedDto::fromArray([
            'id' => $id,
            'published' => $published,
            'is_notify' => $this->request->getFormParam('is_notify'),
        ]);
    }
}
