<?php

namespace App\DTO\Dashboard;

use App\DTO\DataTransferObjectInterface;

readonly  class PublishedTimetableDto implements DataTransferObjectInterface
{
    public function __construct(
        public int $id,
        public int $published,
        public int $isNotify
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            published: (int) $data['published'],
            isNotify: (int) $data['is_notify'],
        );
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'published' => $this->published,
            'is_notify' => $this->isNotify,
        ];
    }
}