<?php

declare(strict_types=1);

namespace App\DTO\Dashboard;

use App\DTO\DataTransferObjectInterface;

readonly class ChangePositionDto implements DataTransferObjectInterface
{
    public function __construct(
        public int $id,
        public string $dir
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) ($data['id'] ?? 0),
            dir: (string) ($data['dir'] ?? '')
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'dir' => $this->dir
        ];
    }
}
