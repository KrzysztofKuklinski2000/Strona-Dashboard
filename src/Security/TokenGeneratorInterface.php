<?php

declare(strict_types=1);

namespace App\Security;

interface TokenGeneratorInterface
{
    public function generate(int $length = 32): string;
}
