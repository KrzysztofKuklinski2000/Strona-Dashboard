<?php

declare(strict_types=1);

namespace App\DTO\Dashboard\News;

use App\DTO\DataTransferObjectInterface;

readonly class UpdateNewsDto implements DataTransferObjectInterface
{
    public function __construct(
        public int $id,
        public string $title,
        public string $updated,
        public string $type,
        public int $status,
        public string $payload,
        public ?array $imageFile,
        public bool $removeImage
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) ($data['id'] ?? 0),
            title: (string) ($data['title'] ?? ''),
            updated: (string) ($data['updated'] ?? ''),
            type: (string) ($data['type'] ?? ''),
            status: (int) ($data['status'] ?? 0),
            payload: (string) ($data['payload'] ?? ''),
            imageFile: $data['imageFile'] ?? null,
            removeImage: (bool) ($data['removeImage'] ?? false)
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'updated' => $this->updated,
            'type' => $this->type,
            'status' => $this->status,
            'payload' => $this->payload,
        ];
    }
}
