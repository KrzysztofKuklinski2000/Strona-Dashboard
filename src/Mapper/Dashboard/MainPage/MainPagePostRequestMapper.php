<?php

namespace App\Mapper\Dashboard\MainPage;

use App\Content\MainPagePostTypes;
use App\Core\Config;
use App\Core\Request;
use App\Core\Validator;
use App\DTO\Dashboard\CreateMainPagePostDto;
use App\DTO\Dashboard\UpdateMainPagePostDto;

class MainPagePostRequestMapper
{
    public function __construct(
        private readonly Request $request,
        private readonly Validator $validator,
        private readonly Config $config,
        private readonly MainPagePayloadNormalizer $payloadNormalizer
    )
    {
    }

    public function mapCreate(): CreateMainPagePostDto {

        $type = $this->validator->validate(
            name: 'postType',
            value: $this->request->getFormParam('postType'),
            required: true,
        );

        if (!MainPagePostTypes::isAllowed((string) $type)) {
            $type = MainPagePostTypes::SIMPLE_TEXT;
        }

        $imageFile = null;

        if($type === MainPagePostTypes::IMAGE_TEXT_LIST) {
            $imageFile = $this->validator->validateFile(
                field: 'postImage',
                file: $this->request->getFile('postImage'),
                maxSize: $this->config->getMaxUploadSize()
            ) ?? null;
        }

        $rawPayload = $this->request->getFormParam('payload') ?? [];

        if (!is_array($rawPayload)) {
            $rawPayload = [];
        }

        $payload = $this->payloadNormalizer->normalize($type, $rawPayload);

        $data =  [


            'title' => $this->validator->validate(
                name: 'postTitle',
                value: $this->request->getFormParam('postTitle'),
                required: true,
                minLength: 10,
                maxLength: 60
            ),

            'created' => date('Y-m-d'),

            'updated' => date('Y-m-d'),

            'status' => 1,

            'type' => $type,

            'payload' => $payload,

            'imageFile' => $imageFile
        ];

        return CreateMainPagePostDto::fromArray($data);
    }

    public function mapUpdate(): UpdateMainPagePostDto {
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

        $imageFile = null;
        $file = $this->request->getFile('postImage');
        $rawImage = is_array($rawPayload['image'] ?? null) ? $rawPayload['image'] : [];
        $hasImage = !empty($rawImage['src']);

        if (
            $type === MainPagePostTypes::IMAGE_TEXT_LIST
            && (
                !$hasImage
                || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE
            )
        ) {
            $imageFile = $this->validator->validateFile(
                field: 'postImage',
                file: $file,
                maxSize: $this->config->getMaxUploadSize()
            );
        }

        $payload = $this->payloadNormalizer->normalize($type, $rawPayload);

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

            'updated' => date('Y-m-d'),

            'type' => $type,

            'payload' => $payload,

            'imageFile' => $imageFile

        ];

        return UpdateMainPagePostDto::fromArray($data);
    }
}