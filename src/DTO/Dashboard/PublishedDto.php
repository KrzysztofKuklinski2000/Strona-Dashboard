<?php

namespace App\DTO\Dashboard;

use App\DTO\DataTransferObjectInterface;

class PublishedDto implements DataTransferObjectInterface
{
    public function __construct(
        public int $id,
        public int $published,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            published: (int) $data['published'],
        );
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'published' => $this->published,
        ];
    }
}