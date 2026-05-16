<?php

namespace App\DTO\Dashboard;

use App\DTO\DataTransferObjectInterface;

readonly class CreatePostDto implements DataTransferObjectInterface
{

    public function __construct(
        public string $title,
        public string $description,
        public string $created,
        public string $updated,
        public string $status,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            title: (string) $data['title'],
            description: (string) $data['description'],
            created: (string) $data['created'],
            updated: (string) $data['updated'],
            status: (string) $data['status'],
        );
    }

    public function toArray(): array {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'created' => $this->created,
            'updated' => $this->updated,
            'status' => $this->status,
        ];
    }
}