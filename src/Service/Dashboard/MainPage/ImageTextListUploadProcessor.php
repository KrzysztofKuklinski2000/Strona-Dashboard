<?php
declare(strict_types=1);

namespace App\Service\Dashboard\MainPage;

use App\Core\FileHandler;
use App\Exception\FileException;
use JsonException;

final readonly class ImageTextListUploadProcessor
{
    public function __construct(
        private FileHandler $fileHandler,
        private string $uploadUrl,
    )
    {
    }

    /**
     * @throws JsonException
     * @throws FileException
     */
    public function process(string $payload, array $imageFile): string {
        $payloadData = json_decode($payload, true, 512, JSON_THROW_ON_ERROR);


        if(!is_array($payloadData)) {
            throw new JsonException('Payload posta musi być obiektem JSON.');
        }

        $imageName = $this->fileHandler->uploadImage($imageFile);

        $image = is_array($payloadData['image'] ?? null) ? $payloadData['image'] : [];

        $image['src'] = rtrim($this->uploadUrl, '/') . '/' .$imageName;
        $payloadData['image'] = $image;

        return json_encode($payloadData, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    }
}