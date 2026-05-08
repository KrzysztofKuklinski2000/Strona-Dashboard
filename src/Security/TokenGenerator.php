<?php

namespace App\Security;

use Random\RandomException;

class TokenGenerator implements TokenGeneratorInterface
{
    /**
     * @throws RandomException
     */
    public function generate(int $length = 32): string {
        return bin2hex(random_bytes($length));
    }
}