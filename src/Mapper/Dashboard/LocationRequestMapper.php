<?php

namespace App\Mapper\Dashboard;


use App\Core\Request;
use App\Core\Validator;
use App\DTO\Dashboard\Location\CreateLocationDto;
use App\DTO\DataTransferObjectInterface;

readonly class LocationRequestMapper
{

    public function __construct(
        private Request $request,
        private Validator $validator,
    )
    {
    }

    public function mapCreate(): DataTransferObjectInterface
    {
        $currentDate = date('Y-m-d');

        $name = $this->validator->validate(
            name: 'name',
            value: $this->request->getFormParam('name'),
            required: true,
            maxLength: 100
        );

        $city = $this->validator->validate(
            name: 'city',
            value: $this->request->getFormParam('city'),
            required: true,
            maxLength: 50
        );

        $address = $this->validator->validate(
            name: 'address',
            value: $this->request->getFormParam('address'),
            required: true,
            maxLength: 200
        );

        $description = $this->validator->validate(
            name: 'description',
            value: $this->request->getFormParam('description'),
            maxLength: 255
        );

        $mapEmbedUrl = $this->validator->validate(
            name: 'map_embed_url',
            value: $this->request->getFormParam('map_embed_url'),
        );

        if ($mapEmbedUrl !== null) {
            $parts = parse_url($mapEmbedUrl) ?: [];
            $path = $parts['path'] ?? '';

            $isValidMap = filter_var($mapEmbedUrl, FILTER_VALIDATE_URL) !== false
                && ($parts['scheme'] ?? '') === 'https'
                && in_array(
                    strtolower($parts['host'] ?? ''),
                    ['www.google.com', 'maps.google.com'],
                    true
                )
                && ($path === '/maps/embed' || str_starts_with($path, '/maps/embed/'));

            if (!$isValidMap) {
                $this->validator->addError(
                    'map_embed_url',
                    'Podaj prawidłowy link do osadzenia mapy Google.'
                );
            }
        }

        $status = $this->validator->validate(
            name: 'status',
            value: $this->request->getFormParam('status'),
            required: true,
            type: 'int',
        );

        if ($status !== null && !in_array($status, [0, 1], true)) {
            $this->validator->addError('status', 'Wybierz prawidłowy status.');
        }

        $data = [
            'name' => $name,
            'city' => $city,
            'address' => $address,
            'description' => $description,
            'map_embed_url' => $mapEmbedUrl,
            'status' => $status,
            'created_at' => $currentDate,
            'updated_at' => $currentDate,
        ];

        return CreateLocationDto::fromArray($data);
    }
}