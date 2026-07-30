<?php
declare(strict_types=1);

namespace App\Traits;

use App\Core\Request;
use App\Core\Validator;
use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\Dashboard\ContactDto;
use App\DTO\Dashboard\CreateGalleryDto;
use App\DTO\Dashboard\CreatePostDto;
use App\DTO\Dashboard\CreateSubscriberDto;
use App\DTO\Dashboard\CreateTimetableDto;
use App\DTO\Dashboard\FeesDto;
use App\DTO\Dashboard\UpdateGalleryDto;
use App\DTO\Dashboard\UpdatePostDto;
use App\DTO\Dashboard\UpdateSubscriberDto;
use App\DTO\Dashboard\UpdateTimetableDto;
use App\DTO\DataTransferObjectInterface;

/**
 * @property Request $request
 * @property Validator $validator
 */
trait GetDataMethods
{
    protected function getDataToChangePostPosition(): DataTransferObjectInterface
    {
        $data = [
            'id' => $this->validator->validate(
                name: 'id',
                value: $this->request->getFormParam('id'),
                required: true,
                type: 'int'
            ),

            'dir' => $this->validator->validate(
                name: 'dir',
                value: $this->request->getFormParam('dir'),
                required: true
            ),
        ];

        return ChangePositionDto::fromArray($data);
    }

    protected function getPostDataToEdit(): UpdatePostDto
    {
        $data = [
            'id' => $this->validator->validate(
                name: 'postId',
                value: $this->request->getFormParam('postId'),
                required: true,
                type: 'int'
            ),

            'title' => $this->validator->validate(
                name: 'postTitle',
                value: $this->request->getFormParam('postTitle'),
                required: true,
                minLength: 10,
                maxLength: 60
            ),

            'description' => $this->validator->validate(
                name: 'postDescription',
                value: $this->request->getFormParam('postDescription'),
                required: true,
                minLength: 20,
                maxLength: 1000
            ),

            'updated' => date('Y-m-d')
        ];

        return UpdatePostDto::fromArray($data);
    }

    protected function getPostDataToCreate(): DataTransferObjectInterface
    {
        $data =  [
            'title' => $this->validator->validate(
                name: 'postTitle',
                value: $this->request->getFormParam('postTitle'),
                required: true,
                minLength: 10,
                maxLength: 60
            ),

            'description' => $this->validator->validate(
                name: 'postDescription',
                value: $this->request->getFormParam('postDescription'),
                required: true,
                minLength: 20,
                maxLength: 1000
            ),

            'created' => date('Y-m-d'),

            'updated' => date('Y-m-d'),

            'status' => 1,
        ];

        return CreatePostDto::fromArray($data);
    }

}
