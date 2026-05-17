<?php

namespace App\DTO\Dashboard;

use App\DTO\DataTransferObjectInterface;

readonly class CreateSubscriberDto implements DataTransferObjectInterface
{
    public function __construct(
        public string $email
    )
    {
    }

    public static function fromArray(array $data): self {
        return new self(
            email: (string) $data['email']
        );
    }

    public function toArray(): array {
        return [
            'email' => $this->email
        ];
    }
}