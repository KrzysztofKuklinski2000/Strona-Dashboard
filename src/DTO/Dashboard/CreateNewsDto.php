<?php

declare(strict_types=1);

namespace App\DTO\Dashboard;

use App\DTO\DataTransferObjectInterface;

readonly class CreateNewsDto implements DataTransferObjectInterface
{
    public function __construct(
        public string $title,
        public string $created,
        public string $updated,
        public int $status,
        public string $type,
        public string $payload
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            title: (string) ($data['title'] ?? ''),
            created: (string) ($data['created'] ?? ''),
            updated: (string) ($data['updated'] ?? ''),
            status: (int) ($data['status'] ?? 0),
            type: (string)$data['type'],
            payload: (string)$data['payload']
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'created' => $this->created,
            'updated' => $this->updated,
            'status' => $this->status,
            'type' => $this->type,
            'payload' => $this->payload
        ];
    }
}
