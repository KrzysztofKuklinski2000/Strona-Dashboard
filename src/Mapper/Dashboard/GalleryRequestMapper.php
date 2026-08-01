<?php

namespace App\Mapper\Dashboard;

use App\Core\Config;
use App\Core\Request;
use App\Core\Validator;
use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\Dashboard\CreateGalleryDto;
use App\DTO\Dashboard\PublishedDto;
use App\DTO\Dashboard\UpdateGalleryDto;

class GalleryRequestMapper
{

    public function __construct(
        private Request                     $request,
        private Validator                   $validator,
        private Config                      $config,
        private ChangePositionRequestMapper $changePositionRequestMapper,
        private PublicationRequestMapper    $publicationRequestMapper,
    )
    {
    }

    public function mapCreate(): CreateGalleryDto
    {
        $data = [
            'category' => $this->validator->validate(
                name: 'category',
                value: $this->request->getFormParam('category'),
                required: true,
                maxLength: 8
            ),

            'description' => $this->validator->validate(
                name: 'description',
                value: $this->request->getFormParam('description'),
                required: true,
                minLength: 10,
                maxLength: 50
            ),

            'image_name' => $this->validator->validateFile(
                field: 'image_name',
                file: $this->request->getFile('image_name'),
                maxSize: $this->config->getMaxUploadSize()
            ),

            'created_at' => date('Y-m-d'),

            'updated_at' => date('Y-m-d'),
        ];

        return CreateGalleryDto::fromArray($data);
    }

    public function mapUpdate(): UpdateGalleryDto
    {
        $data = [
            'id' => $this->validator->validate(
                name: 'id',
                value: $this->request->getFormParam('id'),
                required: true,
                type: 'int'
            ),

            'category' => $this->validator->validate(
                name: 'category',
                value: $this->request->getFormParam('category'),
                required: true,
                maxLength: 8
            ),

            'description' => $this->validator->validate(
                name: 'description',
                value: $this->request->getFormParam('description'),
                required: true,
                minLength: 10,
                maxLength: 50
            ),

            'updated_at' => date('Y-m-d'),
        ];

        return UpdateGalleryDto::fromArray($data);
    }

    public function mapPublication(): PublishedDto
    {
        return $this->publicationRequestMapper->map();
    }

    public function mapChangePosition(): ChangePositionDto
    {
        return $this->changePositionRequestMapper->map();
    }
}