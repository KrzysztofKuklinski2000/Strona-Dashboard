<?php

declare(strict_types=1);

namespace App\Mapper\Dashboard;

use App\Core\Config;
use App\Core\Request;
use App\Core\Validator;
use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\Dashboard\Gallery\CreateGalleryDto;
use App\DTO\Dashboard\Gallery\UpdateGalleryDto;
use App\DTO\Dashboard\PublishedDto;

readonly class GalleryRequestMapper
{
    public function __construct(
        private Request                     $request,
        private Validator                   $validator,
        private Config                      $config,
        private ChangePositionRequestMapper $changePositionRequestMapper,
        private PublicationRequestMapper    $publicationRequestMapper,
        private DeleteRequestMapper         $deleteRequestMapper,
    )
    {
    }

    public function mapCreate(): CreateGalleryDto
    {
        $currentDate = date('Y-m-d');

        $data = [
            ...$this->mapCommonFields(imageRequired: true),
            'created_at' => $currentDate,
            'updated_at' => $currentDate,
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
            ...$this->mapCommonFields(imageRequired: false),
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

    public function mapDelete(): ?int
    {
        return $this->deleteRequestMapper->map();
    }

    private function mapCommonFields(bool $imageRequired): array
    {
        return [
            'category_ids' => $this->mapCategoryIds(),

            'description' => $this->validator->validate(
                name: 'description',
                value: $this->request->getFormParam('description'),
                required: true,
                maxLength: 50
            ),

            'image_name' => $this->validator->validateFile(
                field: 'image_name',
                file: $this->request->getFile('image_name'),
                maxSize: $this->config->getMaxUploadSize(),
                required: $imageRequired,
            ),
        ];
    }

    private function mapCategoryIds(): array
    {
        $rawCategoryIds = $this->request->getFormParam('category_ids', []);

        if (!is_array($rawCategoryIds) || $rawCategoryIds === []) {
            $this->validator->addError(
                'category_ids',
                'Wybierz przynajmniej jedną kategorię'
            );

            return [];
        }

        $categoryIds = [];

        foreach ($rawCategoryIds as $rawCategoryId) {
            $categoryId = $this->validator->validate(
                name: 'category_ids',
                value: $rawCategoryId,
                required: true,
                type: 'int'
            );


            if ($categoryId !== null && $categoryId > 0) {
                $categoryIds[] = (int)$categoryId;
            }
        }

        $categoryIds = array_values(array_unique($categoryIds));

        if ($categoryIds === []) {
            $this->validator->addError(
                'category_ids',
                'Wybierz przynajmniej jedną prawidłową kategorię.'
            );
        }

        return $categoryIds;
    }
}
