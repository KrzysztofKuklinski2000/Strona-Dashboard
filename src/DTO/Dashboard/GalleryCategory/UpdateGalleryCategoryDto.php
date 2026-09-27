<?php
declare(strict_types=1);

namespace App\DTO\Dashboard\GalleryCategory;

use App\DTO\DataTransferObjectInterface;

final readonly class UpdateGalleryCategoryDto implements DataTransferObjectInterface
{
    public function __construct(
        public int    $id,
        public string $name,
        public string $slug,
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
            updatedAt: (string)$data['updated_at'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'updated_at' => $this->updatedAt,
        ];
    }
}