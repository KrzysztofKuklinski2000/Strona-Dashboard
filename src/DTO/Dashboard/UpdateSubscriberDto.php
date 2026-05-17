<?php
declare(strict_types=1);

namespace App\DTO\Dashboard;

use App\DTO\DataTransferObjectInterface;

readonly class UpdateSubscriberDto implements DataTransferObjectInterface
{
    public function __construct(
        public int $id,
        public string $email,
        public int $isActive
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int)($data['id'] ?? 0),
            email: (string)($data['email'] ?? ''),
            isActive: (int)($data['is_active'] ?? 0)
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'is_active' => $this->isActive
        ];
    }
}