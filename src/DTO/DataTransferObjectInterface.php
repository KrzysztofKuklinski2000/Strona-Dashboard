<?php

declare(strict_types=1);

namespace App\DTO;

interface DataTransferObjectInterface
{
    public static function fromArray(array $data): self;

    public function toArray(): array;
}
