<?php

namespace App\Security;

interface TokenGeneratorInterface
{
    public function generate(int $length = 32): string;
}