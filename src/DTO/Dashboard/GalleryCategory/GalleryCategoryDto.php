<?php
declare(strict_types=1);

namespace App\DTO\Dashboard\GalleryCategory;

use App\DTO\DataTransferObjectInterface;

final readonly class GalleryCategoryDto implements DataTransferObjectInterface
{
    public function __construct(
        public int    $id,
        public string $name,
        public string $slug,
        public int    $position,
        public int    $status,
        public string $createdAt,
        public string $updatedAt,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int)$data['id'],
            name: (string)$data['name'],
            slug: (string)$data['slug'],
            position: (int)$data['position'],
            status: (int)$data['status'],
            createdAt: (string)$data['created_at'],
            updatedAt: (string)$data['updated_at'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'status' => $this->status,
            'position' => $this->position,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}