<?php

namespace App\Mapper\Dashboard;


use App\Core\Request;
use App\Core\Validator;
use App\DTO\Dashboard\Location\CreateLocationDto;
use App\DTO\Dashboard\Location\UpdateLocationDto;
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
        $data = [
            ...$this->mapCommonFields(),
            'created_at' => date('Y-m-d'),
        ];

        return CreateLocationDto::fromArray($data);
    }

    public function mapUpdate(): UpdateLocationDto {
        return UpdateLocationDto::fromArray([
            'id' => $this->validator->validate(
                name: 'id',
                value: $this->request->getFormParam('id'),
                required: true,
                type: 'int',
            ),
            ...$this->mapCommonFields(),
        ]);
    }

    private function mapCommonFields(): array
    {

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

        return [
            'name' => $name,
            'city' => $city,
            'address' => $address,
            'description' => $description,
            'map_embed_url' => $mapEmbedUrl,
            'updated_at' => date('Y-m-d'),
        ];
    }
}