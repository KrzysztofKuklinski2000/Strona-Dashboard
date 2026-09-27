<?php
declare(strict_types=1);

namespace App\Mapper\Dashboard;

use App\Core\Request;
use App\Core\Validator;
use App\DTO\Dashboard\GalleryCategory\CreateGalleryCategoryDto;
use App\DTO\Dashboard\GalleryCategory\UpdateGalleryCategoryDto;
use App\Mapper\SlugNormalizer;

readonly class GalleryCategoryRequestMapper
{
    public function __construct(
        private Request        $request,
        private Validator      $validator,
        private SlugNormalizer $slugNormalizer,
    )
    {
    }


    public function mapCreate(): CreateGalleryCategoryDto
    {
        $currentDate = date('Y-m-d');

        $name = $this->validator->validate(
            name: 'name',
            value: $this->request->getFormParam('name'),
            required: true,
            maxLength: 100
        );

        $slug = '';

        if (is_string($name)) {
            $slug = $this->slugNormalizer->normalize($name);

            if ($slug === '') {
                $this->validator->addError('name', 'Nazwa musi zawierać litery lub cyfry.');
            }
        }


        $data = [
            'name' => $name,
            'slug' => $slug,
            'created_at' => $currentDate,
            'updated_at' => $currentDate,
        ];
        return CreateGalleryCategoryDto::fromArray($data);
    }

    public function mapUpdate(): UpdateGalleryCategoryDto
    {

        $name = $this->validator->validate(
            name: 'name',
            value: $this->request->getFormParam('name'),
            required: true,
            maxLength: 100
        );

        $slug = '';

        if (is_string($name)) {
            $slug = $this->slugNormalizer->normalize($name);

            if ($slug === '') {
                $this->validator->addError('name', 'Nazwa musi zawierać litery lub cyfry.');
            }
        }


        $data = [
            'id' => $this->validator->validate(
                name: 'id',
                value: $this->request->getFormParam('id'),
                required: true,
                type: 'int'
            ),
            'name' => $name,
            'slug' => $slug,
            'updated_at' => date('Y-m-d'),
        ];
        return UpdateGalleryCategoryDto::fromArray($data);
    }
}