<?php

namespace App\DTO\Dashboard;

use App\DTO\DataTransferObjectInterface;

readonly class UpdateMainPageDto implements DataTransferObjectInterface
{
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public string $updated,
        public string $type,
        public ?string $payload,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            title: (string) $data['title'],
            description: (string) $data['description'],
            updated: (string) $data['updated'],
            type: (string) ($data['type'] ?? 'simple_text'),
            payload: isset($data['payload']) ? (string) $data['payload'] : null,
        );
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'updated' => $this->updated,
            'type' => $this->type,
            'payload' => $this->payload,
        ];
    }
}