<?php

declare(strict_types=1);

namespace App\DTO\Dashboard;

use App\DTO\DataTransferObjectInterface;

readonly class UpdateNewsDto implements DataTransferObjectInterface
{
    public function __construct(
        public int $id,
        public string $title,
        public string $updated,
        public string $type,
        public string $payload
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) ($data['id'] ?? 0),
            title: (string) ($data['title'] ?? ''),
            updated: (string) ($data['updated'] ?? ''),
            type: (string) ($data['type'] ?? ''),
            payload: (string) ($data['payload'] ?? ''),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'updated' => $this->updated,
            'type' => $this->type,
            'payload' => $this->payload,
        ];
    }
}
