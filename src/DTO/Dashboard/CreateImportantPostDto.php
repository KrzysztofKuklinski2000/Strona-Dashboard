<?php

declare(strict_types=1);

namespace App\DTO\Dashboard;

use App\DTO\DataTransferObjectInterface;

readonly class CreateImportantPostDto implements DataTransferObjectInterface
{
    public function __construct(
        public string $title,
        public string $description,
        public string $created,
        public string $updated,
        public int $status,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            title: (string) ($data['title'] ?? ''),
            description: (string) ($data['description'] ?? ''),
            created: (string) ($data['created'] ?? ''),
            updated: (string) ($data['updated'] ?? ''),
            status: (int) ($data['status'] ?? 0),
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'created' => $this->created,
            'updated' => $this->updated,
            'status' => $this->status,
        ];
    }
}
