<?php

namespace App\DTO\Dashboard\Location;

use App\DTO\DataTransferObjectInterface;

class LocationDto implements DataTransferObjectInterface
{
    public function __construct(
        public int    $id,
        public string $name,
        public string $city,
        public string $address,
        public string $description,
        public string $map_embed_url,
        public int    $status,
        public string $createdAt,
        public string $updatedAt,
    )
    {

    }

    public static function fromArray(array $data): DataTransferObjectInterface
    {
        return new self(
            id: (int)$data['id'] ,
            name: (string)($data['name'] ?? ''),
            city: (string)($data['city'] ?? ''),
            address: (string)($data['address'] ?? ''),
            description: (string)($data['description'] ?? ''),
            map_embed_url: (string)($data['map_embed_url'] ?? ''),
            status: (int)($data['status'] ?? 0),
            createdAt: (string)($data['created_at'] ?? ''),
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
            'map_embed_url' => $this->map_embed_url,
            'status' => $this->status,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}