<?php
declare(strict_types=1);

namespace App\Traits;

use App\Content\MainPagePostTypes;
use App\Core\Request;
use App\Core\Validator;
use App\DTO\Dashboard\CampDto;
use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\Dashboard\ContactDto;
use App\DTO\Dashboard\CreateGalleryDto;
use App\DTO\Dashboard\CreateMainPagePostDto;
use App\DTO\Dashboard\CreatePostDto;
use App\DTO\Dashboard\CreateSubscriberDto;
use App\DTO\Dashboard\CreateTimetableDto;
use App\DTO\Dashboard\FeesDto;
use App\DTO\Dashboard\PublishedDto;
use App\DTO\Dashboard\PublishedTimetableDto;
use App\DTO\Dashboard\UpdateGalleryDto;
use App\DTO\Dashboard\UpdateMainPagePostDto;
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

    protected function getDataToPublished(): DataTransferObjectInterface
    {
        $data = [
            'published' => $this->validator->validate(
                name: 'postPublished',
                value: $this->request->getFormParam('postPublished'),
                required: true
            ),

            'id' => $this->validator->validate(
                name: 'postId',
                value: $this->request->getFormParam('postId'),
                required: true
            )
        ];

        return PublishedDto::fromArray($data);
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

    protected function getMainPagePostDataToCreate(): DataTransferObjectInterface
    {
        $type = $this->validator->validate(
            name: 'postType',
            value: $this->request->getFormParam('postType'),
            required: true,
        );

        if (!MainPagePostTypes::isAllowed((string) $type)) {
            $type = MainPagePostTypes::SIMPLE_TEXT;
        }

        $rawPayload = $this->request->getFormParam('payload') ?? [];

        if (!is_array($rawPayload)) {
            $rawPayload = [];
        }

        $payload = $this->normalizeMainPagePayload($type, $rawPayload);

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

            'type' => $type,

            'payload' => $payload
        ];

        return CreateMainPagePostDto::fromArray($data);
    }

    protected function getMainPagePostDataToUpdate(): DataTransferObjectInterface
    {
        $type = $this->validator->validate(
            name: 'postType',
            value: $this->request->getFormParam('postType'),
            required: true,
        );

        if (!MainPagePostTypes::isAllowed((string) $type)) {
            $type = MainPagePostTypes::SIMPLE_TEXT;
        }

        $rawPayload = $this->request->getFormParam('payload') ?? [];

        if (!is_array($rawPayload)) {
            $rawPayload = [];
        }

        $payload = $this->normalizeMainPagePayload($type, $rawPayload);

        $data =  [
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

            'updated' => date('Y-m-d'),

            'type' => $type,

            'payload' => $payload
        ];

        return UpdateMainPagePostDto::fromArray($data);
    }

    protected function getDataToCampEdit(): CampDto
    {
        $data = [
            'city' => $this->validator->validate(
                name: 'town',
                value: $this->request->getFormParam('town'),
                required: true,
                maxLength: 50
            ),

            'guesthouse' => $this->validator->validate(
                name: 'guesthouse',
                value: $this->request->getFormParam('guesthouse'),
                required: true,
                maxLength: 70
            ),

            'city_start' => $this->validator->validate(
                name: 'townStart',
                value: $this->request->getFormParam('townStart'),
                required: true,
                maxLength: 50
            ),

            'date_start' => $this->validator->validate(
                name: 'dateStart',
                value: $this->request->getFormParam('dateStart'),
                required: true
            ),

            'date_end' => $this->validator->validate(
                name: 'dateEnd',
                value: $this->request->getFormParam('dateEnd'),
                required: true
            ),

            'time_start' => $this->validator->validate(
                name: 'timeStart',
                value: $this->request->getFormParam('timeStart'),
                required: true
            ),

            'time_end' => $this->validator->validate(
                name: 'timeEnd',
                value: $this->request->getFormParam('timeEnd'),
                required: true
            ),

            'place' => $this->validator->validate(
                name: 'place',
                value: $this->request->getFormParam('place'),
                required: true,
                maxLength: 100
            ),

            'accommodation' => $this->validator->validate(
                name: 'accommodation',
                value: $this->request->getFormParam('accommodation'),
                required: true,
                maxLength: 500
            ),

            'meals' => $this->validator->validate(
                name: 'meals',
                value: $this->request->getFormParam('meals'),
                required: true,
                maxLength: 500
            ),

            'trips' => $this->validator->validate(
                name: 'trips',
                value: $this->request->getFormParam('trips'),
                required: true,
                maxLength: 500
            ),

            'staff' => $this->validator->validate(
                name: 'staff',
                value: $this->request->getFormParam('staff'),
                required: true,
                maxLength: 500
            ),

            'transport' => $this->validator->validate(
                name: 'transport',
                value: $this->request->getFormParam('transport'),
                required: true,
                maxLength: 500
            ),

            'training' => $this->validator->validate(
                name: 'training',
                value: $this->request->getFormParam('training'),
                required: true,
                maxLength: 500
            ),

            'insurance' => $this->validator->validate(
                name: 'insurance',
                value: $this->request->getFormParam('insurance'),
                required: true,
                maxLength: 500
            ),

            'cost' => $this->validator->validate(
                name: 'cost',
                value: $this->request->getFormParam('cost'),
                required: true,
                type: 'int'
            ),

            'advancePayment' => $this->validator->validate(
                name: 'advancePayment',
                value: $this->request->getFormParam('advancePayment'),
                required: true,
                type: 'int'
            ),

            'advanceDate' => $this->validator->validate(
                name: 'advanceDate',
                value: $this->request->getFormParam('advanceDate'),
                required: true,
            ),
        ];

        return CampDto::fromArray($data);
    }

    protected function getDataToFeesEdit(): FeesDto
    {
        $data = [
            'reduced_contribution_1_month' => $this->validator->validate(
                name: 'n1',
                value: $this->request->getFormParam('n1'),
                required: true,
                type: 'int'
            ),

            'reduced_contribution_2_month' => $this->validator->validate(
                name: 'n2',
                value: $this->request->getFormParam('n2'),
                required: true,
                type: 'int'
            ),

            'family_contribution_month' => $this->validator->validate(
                name: 'n3',
                value: $this->request->getFormParam('n3'),
                required: true,
                type: 'int'
            ),

            'reduced_contribution_1_year' => $this->validator->validate(
                name: 'n6',
                value: $this->request->getFormParam('n6'),
                required: true,
                type: 'int'
            ),

            'reduced_contribution_2_year' => $this->validator->validate(
                name: 'n7',
                value: $this->request->getFormParam('n7'),
                required: true,
                type: 'int'
            ),

            'family_contribution_year' => $this->validator->validate(
                name: 'n8',
                value: $this->request->getFormParam('n8'),
                required: true,
                type: 'int'
            ),

            'extra_information' => $this->validator->validate(
                name: 'n10',
                value: $this->request->getFormParam('n10'),
                required: true,
            ),

            'fees_information' => $this->validator->validate(
                name: 'n11',
                value: $this->request->getFormParam('n11'),
                required: true,
            ),
        ];

        return FeesDto::fromArray($data);
    }

    protected function getDataToContactEdit(): ContactDto
    {
        $data = [
            'email' => $this->validator->validate(
                name: 'email',
                value: $this->request->getFormParam('email'),
                required: true,
                maxLength: 100
            ),

            'phone' => $this->validator->validate(
                name: 'phone',
                value: $this->request->getFormParam('phone'),
                required: true,
                maxLength: 9
            ),

            'address' => $this->validator->validate(
                name: 'address',
                value: $this->request->getFormParam('address'),
                required: true,
            ),
        ];

        return ContactDto::fromArray($data);
    }

    protected function getDataToAddTimetable(): DataTransferObjectInterface
    {
        $data = [
            'day' => $this->validator->validate(
                name: 'day',
                value: $this->request->getFormParam('day'),
                required: true,
                maxLength: 20
            ),

            'city' => $this->validator->validate(
                name: 'city',
                value: $this->request->getFormParam('city'),
                required: true,
                maxLength: 40
            ),

            'advancement_group' => $this->validator->validate(
                name: 'group',
                value: $this->request->getFormParam('group'),
                required: true,
                maxLength: 40
            ),

            'place' => $this->validator->validate(
                name: 'place',
                value: $this->request->getFormParam('place'),
                required: true,
                maxLength: 100
            ),

            'start' => $this->validator->validate(
                name: 'startTime',
                value: $this->request->getFormParam('startTime'),
                required: true,
            ),

            'end' => $this->validator->validate(
                name: 'endTime',
                value: $this->request->getFormParam('endTime'),
                required: true,
            ),

            'is_notify' => $this->request->getFormParam('is_notify')
        ];

        return CreateTimetableDto::fromArray($data);
    }

    protected function getDataToEditTimetable(): DataTransferObjectInterface
    {
        $data = [
            'id' => $this->validator->validate(
                name: 'id',
                value: $this->request->getFormParam('id'),
                required: true,
                type: 'int'
            ),

            'day' => $this->validator->validate(
                name: 'day',
                value: $this->request->getFormParam('day'),
                required: true,
                maxLength: 20
            ),

            'city' => $this->validator->validate(
                name: 'city',
                value: $this->request->getFormParam('city'),
                required: true,
                maxLength: 40
            ),

            'advancement_group' => $this->validator->validate(
                name: 'group',
                value: $this->request->getFormParam('group'),
                required: true,
                maxLength: 40
            ),

            'place' => $this->validator->validate(
                name: 'place',
                value: $this->request->getFormParam('place'),
                required: true,
                maxLength: 100
            ),

            'start' => $this->validator->validate(
                name: 'startTime',
                value: $this->request->getFormParam('startTime'),
                required: true,
            ),

            'end' => $this->validator->validate(
                name: 'endTime',
                value: $this->request->getFormParam('endTime'),
                required: true,
            ),

            'is_notify' => $this->request->getFormParam('is_notify')
        ];

        return UpdateTimetableDto::fromArray($data);
    }

    protected function getDataToPublishedTimetable(): DataTransferObjectInterface
    {
        $data = [
            'published' => $this->validator->validate(
                name: 'postPublished',
                value: $this->request->getFormParam('postPublished'),
                required: true
            ),

            'id' => $this->validator->validate(
                name: 'postId',
                value: $this->request->getFormParam('postId'),
                required: true
            ),

            'is_notify' => $this->request->getFormParam('is_notify')
        ];

        return PublishedTimetableDto::fromArray($data);
    }

    protected function getDataToAddImage(): CreateGalleryDto
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
                maxSize: $this->contextController->config->getMaxUploadSize()
            ),

            'created_at' => date('Y-m-d'),

            'updated_at' => date('Y-m-d'),
        ];

        return CreateGalleryDto::fromArray($data);
    }

    protected function getDataToEditImage(): UpdateGalleryDto
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

    protected function getEmailToCreate(): DataTransferObjectInterface
    {
        $data = [
            'email' => $this->validator->validate(
                name: 'email',
                value: $this->request->getFormParam('email'),
                required: true,
                type: 'email',
                maxLength: 100
            )
        ];

        return CreateSubscriberDto::fromArray($data);
    }

    protected function getEmailToUpdate(): DataTransferObjectInterface
    {
        $data = [

            'id' => $this->validator->validate(
                name: 'id',
                value: $this->request->getFormParam('id'),
                required: true,
                type: 'int'
            ),

            'email' => $this->validator->validate(
                name: 'email',
                value: $this->request->getFormParam('email'),
                required: true,
                type: 'email',
                maxLength: 100
            ),

            'is_active' => (int) $this->validator->validate(
                name: 'is_active',
                value: $this->request->getFormParam('is_active')
            )
        ];
        return UpdateSubscriberDto::fromArray($data);
    }

    private function normalizeMainPagePayload(string $type, array $rawPayload): ?string
    {
        if ($type === 'simple_text') {
            return null;
        }

        if ($type === 'cards_grid') {
            return json_encode([
                'eyebrow' => $rawPayload['eyebrow'] ?? '',
                'cards' => $rawPayload['cards'] ?? [],
            ], JSON_UNESCAPED_UNICODE);
        }

        if ($type === 'image_text_list') {
            return json_encode([
                'eyebrow' => $rawPayload['eyebrow'] ?? '',
                'image' => [
                    'src' => $rawPayload['image']['src'] ?? '',
                    'alt' => $rawPayload['image']['alt'] ?? '',
                ],
                'items' => $rawPayload['items'] ?? [],
                'link' => [
                    'label' => $rawPayload['link']['label'] ?? '',
                    'url' => $rawPayload['link']['url'] ?? '',
                ],
            ], JSON_UNESCAPED_UNICODE);
        }

        return null;
    }
}
