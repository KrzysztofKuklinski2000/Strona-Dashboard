<?php

declare(strict_types=1);

namespace App\DTO\Dashboard;

use App\DTO\DataTransferObjectInterface;

readonly class UpdateGalleryDto implements DataTransferObjectInterface
{
    public function __construct(
        public int $id,
        public string $category,
        public string $description,
        public array|string|null $imageName,
        public string $updatedAt
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int)($data['id'] ?? 0),
            category: (string)($data['category'] ?? ''),
            description: (string)($data['description'] ?? ''),
            imageName: $data['image_name'] ?? null,
            updatedAt: (string)($data['updated_at'] ?? '')
        );
    }

    public function toArray(): array
    {
        $data = [
            'id' => $this->id,
            'category' => $this->category,
            'description' => $this->description,
            'updated_at' => $this->updatedAt
        ];

        if (is_string($this->imageName) && $this->imageName !== '') {
            $data['image_name'] = $this->imageName;
        }

        return $data;
    }
}
