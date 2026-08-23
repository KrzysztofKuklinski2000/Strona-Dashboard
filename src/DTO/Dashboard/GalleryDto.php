<?php

declare(strict_types=1);

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
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            imageName: (string) $data['image_name'],
            description: (string) $data['description'],
            createdAt: (string) $data['created_at'],
            updatedAt: (string) $data['updated_at'],
            position: (int) $data['position'],
            category: $data['category'],
            status: (int) $data['status'],
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
