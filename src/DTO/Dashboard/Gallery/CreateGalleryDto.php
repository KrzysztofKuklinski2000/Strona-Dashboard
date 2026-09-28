<?php

declare(strict_types=1);

namespace App\DTO\Dashboard\Gallery;

use App\DTO\DataTransferObjectInterface;

readonly class CreateGalleryDto implements DataTransferObjectInterface
{
    public function __construct(
        public array $categoryIds,
        public string $description,
        public array|string|null $imageName,
        public string $createdAt,
        public string $updatedAt,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            categoryIds: $data['category_ids'] ?? [],
            description: (string) ($data['description'] ?? ''),
            imageName: $data['image_name'] ?? null,
            createdAt: (string) ($data['created_at'] ?? ''),
            updatedAt: (string) ($data['updated_at'] ?? ''),
        );
    }

    public function toArray(): array
    {
        return [
            'description' => $this->description,
            'image_name' => $this->imageName,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
