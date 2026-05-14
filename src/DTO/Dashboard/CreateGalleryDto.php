<?php

namespace App\DTO\Dashboard;

use App\DTO\DataTransferObjectInterface;

readonly class CreateGalleryDto implements DataTransferObjectInterface
{
    public function __construct(
        public string $category,
        public string $description,
        public array $imageName,
        public string $createdAt,
        public string $updatedAt,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            category: (string) $data['category'],
            description: (string) $data['description'],
            imageName: $data['image_name'],
            createdAt: (string) $data['created_at'],
            updatedAt: (string) $data['updated_at'],
        );
    }

    public function toArray(): array {
        return [
            'category' => $this->category,
            'description' => $this->description,
            'image_name' => $this->imageName,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}