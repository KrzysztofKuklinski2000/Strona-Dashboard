<?php
declare(strict_types=1);

namespace App\DTO\Dashboard\GalleryCategory;

use App\DTO\DataTransferObjectInterface;

final readonly class CreateGalleryCategoryDto implements DataTransferObjectInterface
{
    public function __construct(
        public string $name,
        public string $slug,
        public string $createdAt,
        public string $updatedAt,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: (string)$data['name'],
            slug: (string)$data['slug'],
            createdAt: (string)$data['created_at'],
            updatedAt: (string)$data['updated_at'],
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}