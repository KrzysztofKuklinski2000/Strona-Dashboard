<?php

namespace App\DTO\Dashboard\Location;

use App\DTO\DataTransferObjectInterface;

class CreateLocationDto implements DataTransferObjectInterface
{
    public function __construct(
        public string $name,
        public string $city,
        public string $address,
        public string $description,
        public string $mapEmbedUrl,
        public int $status,
        public string $createdAt,
        public string $updatedAt,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: (string)($data['name'] ?? ''),
            city: (string)($data['city'] ?? ''),
            address: (string)($data['address'] ?? ''),
            description: (string)($data['description'] ?? ''),
            mapEmbedUrl: (string)($data['map_embed_url'] ?? ''),
            status: (int)($data['status'] ?? 0),
            createdAt: (string)($data['created_at'] ?? ''),
            updatedAt: (string)($data['updated_at'] ?? ''),
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'city' => $this->city,
            'address' => $this->address,
            'description' => $this->description,
            'map_embed_url' => $this->mapEmbedUrl,
            'status' => $this->status,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}