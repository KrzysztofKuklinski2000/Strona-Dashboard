<?php

namespace App\DTO\Dashboard;

use App\DTO\DataTransferObjectInterface;

readonly class GalleryDto implements DataTransferObjectInterface
{

    public function __construct(
        public int $id,
        public string $imageName,
        public string $description,
        public string $createdAt,
        public string $updatedAt,
        public int $position,
        public ?string $category,
        public int $status,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            imageName: $data['image_name'],
            description: $data['description'],
            createdAt: $data['created_at'],
            updatedAt: $data['updated_at'],
            position: $data['position'],
            category: $data['category'],
            status: $data['status'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'image_name' => $this->imageName,
            'description' => $this->description,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'position' => $this->position,
            'category' => $this->category,
            'status' => $this->status,
        ];
    }

}