<?php

namespace App\Service\Contracts;

use App\DTO\Dashboard\ContactDto;

interface ContactProviderInterface
{
    public function getContact(): ContactDto;
}