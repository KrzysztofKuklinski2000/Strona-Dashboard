<?php

namespace App\DTO\Dashboard;

use App\DTO\DataTransferObjectInterface;

readonly class UpdatePostDto implements DataTransferObjectInterface
{
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public string $updated
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
          id: (int) ($data['id'] ?? 0),
          title: (string) ($data['title'] ?? ''),
          description: (string) ($data['description'] ?? ''),
          updated: (string) ($data['updated'] ?? ''),
        );
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'updated' => $this->updated,
        ];
    }
}