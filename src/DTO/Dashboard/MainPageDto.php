<?php

namespace App\DTO\Dashboard;

use App\DTO\DataTransferObjectInterface;

readonly class MainPageDto implements DataTransferObjectInterface
{
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public string $created,
        public string $updated,
        public int $status,
        public int $position,
    )
    {
    }


    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            title: (string) $data['title'],
            description: (string) $data['description'],
            created: (string) $data['created'],
            updated: (string) $data['updated'],
            status: (int) $data['status'],
            position: (int) $data['position'],
        );
    }

    public function toArray(): array {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "description" => $this->description,
            "created" => $this->created,
            "updated" => $this->updated,
            "status" => $this->status,
            "position" => $this->position
        ];
    }
}