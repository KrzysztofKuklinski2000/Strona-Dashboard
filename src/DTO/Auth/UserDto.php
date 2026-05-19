<?php
declare(strict_types=1);

namespace App\DTO\Auth;

use App\DTO\DataTransferObjectInterface;

readonly class UserDto implements DataTransferObjectInterface
{
    public function __construct(
        public int $id,
        public string $login
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int)$data['id'],
            login: (string)$data['login']
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'login' => $this->login
        ];
    }
}