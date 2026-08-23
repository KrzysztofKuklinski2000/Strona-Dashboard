<?php

declare(strict_types=1);

namespace App\DTO\Dashboard;

use App\DTO\DataTransferObjectInterface;

readonly class CreateHomepagePostDto implements DataTransferObjectInterface
{
    public function __construct(
        public string $title,
        public string $created,
        public string $updated,
        public int $status,
        public int $position,
        public string $type,
        public ?string $payload,
        public ?array $imageFile,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            title: (string) $data['title'],
            created: (string) $data['created'],
            updated: (string) $data['updated'],
            status: (int) $data['status'],
            position: (int) ($data['position'] ?? 2),
            type: (string) ($data['type'] ?? 'simple_text'),
            payload: isset($data['payload']) ? (string) $data['payload'] : null,
            imageFile: $data['imageFile'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'created' => $this->created,
            'updated' => $this->updated,
            'status' => $this->status,
            'position' => $this->position,
            'type' => $this->type,
            'payload' => $this->payload,
        ];
    }
}
