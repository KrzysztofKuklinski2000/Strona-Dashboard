<?php

declare(strict_types=1);

namespace App\Mapper\Dashboard\Payload;

interface PayloadNormalizerInterface
{
    public function normalize(array $rawPayload): array;
}
