<?php

namespace App\DTO\Dashboard;

use App\DTO\DataTransferObjectInterface;

readonly class UpdateMainPagePostDto implements DataTransferObjectInterface
{
    public function __construct(
        public int $id,
        public string $title,
        public string $updated,
        public string $type,
        public ?string $payload,
        public ?array $imageFile,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            title: (string) $data['title'],
            updated: (string) $data['updated'],
            type: (string) ($data['type'] ?? 'simple_text'),
            payload: isset($data['payload']) ? (string) $data['payload'] : null,
            imageFile: $data['imageFile'] ?? null,
        );
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'updated' => $this->updated,
            'type' => $this->type,
            'payload' => $this->payload,
        ];
    }
}
