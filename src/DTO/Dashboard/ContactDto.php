<?php

declare(strict_types=1);

namespace App\DTO\Dashboard;

use App\DTO\DataTransferObjectInterface;

readonly class ContactDto implements DataTransferObjectInterface
{
    public function __construct(
        public int    $id,
        public string $email,
        public string $phone,
        public string $address,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) ($data['id'] ?? 1),
            email: (string)$data['email'],
            phone: (string)$data['phone'],
            address: (string)$data['address'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
        ];
    }


}
