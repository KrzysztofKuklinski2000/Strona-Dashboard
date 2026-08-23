<?php
declare(strict_types=1);

namespace App\Service\Dashboard\Homepage;

use App\Core\FileHandler;
use App\Exception\FileException;
use JsonException;

final readonly class ImageTextListImageProcessor
{
    public function __construct(
        private FileHandler $fileHandler,
        private string      $uploadUrl,
    )
    {
    }

    /**
     * @throws JsonException
     * @throws FileException
     */
    public function process(string $payload, array $imageFile): string
    {
        $payloadData = $this->decodePayload($payload);
        $imageName = $this->fileHandler->uploadImage($imageFile);

        return $this->addImageSource($payloadData, $imageName);
    }

    /**
     * @throws JsonException
     */
    public function preserveImageSource(string $payload, string $imageName): string
    {
        $payloadData = $this->decodePayload($payload);

        return $this->addImageSource($payloadData, $imageName);
    }

    /**
     * @throws FileException
     */
    public function deleteImage(string $imageName): void
    {
        $this->fileHandler->deleteImage($imageName);
    }

    /**
     * @throws JsonException
     */
    public function extractImageName(?string $payload): ?string
    {
        if ($payload === null || $payload === '') {
            return null;
        }

        $payloadData = $this->decodePayload($payload);

        $image = $payloadData['image'] ?? null;

        if (!is_array($image)) {
            return null;
        }

        $imageSrc = $image['src'] ?? null;

        if (!is_string($imageSrc)) {
            return null;
        }

        $imageName = basename($imageSrc);
        $expectedPath = rtrim($this->uploadUrl, '/') . '/' . $imageName;

        return $imageSrc === $expectedPath ? $imageName : null;
    }

    /**
     * @throws JsonException
     */
    private function decodePayload(string $payload): array
    {
        $payloadData = json_decode(
            $payload,
            true,
            512,
            JSON_THROW_ON_ERROR,
        );

        if (!is_array($payloadData)) {
            throw new JsonException('Payload posta musi być obiektem JSON.');
        }

        return $payloadData;
    }

    /**
     * @throws JsonException
     */
    private function addImageSource(array $payloadData, string $imageName): string
    {
        $image = is_array($payloadData['image'] ?? null)
            ? $payloadData['image']
            : [];

        $image['src'] = rtrim($this->uploadUrl, '/') . '/' . $imageName;
        $payloadData['image'] = $image;

        return json_encode(
            $payloadData,
            JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR,
        );
    }
}