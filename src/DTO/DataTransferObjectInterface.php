<?php

namespace App\DTO;

interface DataTransferObjectInterface
{
    public static function fromArray(array $data): self;
}