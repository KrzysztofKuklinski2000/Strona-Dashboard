<?php

declare(strict_types=1);

namespace App\DTO\Dashboard;

use App\DTO\DataTransferObjectInterface;

readonly class PublishedDto implements DataTransferObjectInterface
{
    public function __construct(
        public int $id,
        public int $published,
        public bool $isNotify,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) ($data['id'] ?? 0),
            published: (int) ($data['published'] ?? 0),
            isNotify: !empty($data['is_notify']),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'published' => $this->published,
        ];
    }
}
