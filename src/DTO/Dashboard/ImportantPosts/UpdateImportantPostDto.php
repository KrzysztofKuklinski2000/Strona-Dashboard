<?php

declare(strict_types=1);

namespace App\DTO\Dashboard\ImportantPosts;

use App\DTO\DataTransferObjectInterface;

readonly class UpdateImportantPostDto implements DataTransferObjectInterface
{
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public int $status,
        public string $updated,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) ($data['id'] ?? 0),
            title: (string) ($data['title'] ?? ''),
            description: (string) ($data['description'] ?? ''),
            status: (int) ($data['status'] ?? 0),
            updated: (string) ($data['updated'] ?? ''),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'updated' => $this->updated,
        ];
    }
}
