<?php

namespace App\DTO\Dashboard;

use App\DTO\DataTransferObjectInterface;

readonly class SubscribersDto implements DataTransferObjectInterface
{
    public function __construct(
        public int $id,
        public string $email,
        public int $isActive,
        public string $token
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            email: (string) $data['email'],
            isActive: (int) $data['is_active'],
            token: (string) $data['token']
        );
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'is_active' => $this->isActive,
            'token' => $this->token,
        ];
    }
}