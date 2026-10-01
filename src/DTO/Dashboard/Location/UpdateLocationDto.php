<?php

namespace App\DTO\Dashboard\Location;

use App\DTO\DataTransferObjectInterface;

class UpdateLocationDto implements DataTransferObjectInterface
{
    public function __construct(
        public int    $id,
        public string $name,
        public string $city,
        public string $address,
        public string $description,
        public string $mapEmbedUrl,
        public string $updatedAt,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int)($data['id'] ?? 0),
            name: (string)($data['name'] ?? ''),
            city: (string)($data['city'] ?? ''),
            address: (string)($data['address'] ?? ''),
            description: (string)($data['description'] ?? ''),
            mapEmbedUrl: (string)($data['map_embed_url'] ?? ''),
            updatedAt: (string)($data['updated_at'] ?? ''),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'city' => $this->city,
            'address' => $this->address,
            'description' => $this->description,
            'map_embed_url' => $this->mapEmbedUrl,
            'updated_at' => $this->updatedAt,
        ];
    }
}