<?php

namespace App\DTO\Dashboard;

use App\DTO\DataTransferObjectInterface;

readonly class ContactDto implements DataTransferObjectInterface
{
    public function __construct(
        public string $email,
        public string $phone,
        public string $address,
    )
    {
    }

    public static function fromArray(array $data): self {
        return new self(
            email: (string) $data['email'],
            phone: (string) $data['phone'],
            address: (string) $data['address'],
        );
    }

    public function toArray(): array {
        return [
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
        ];
    }


}