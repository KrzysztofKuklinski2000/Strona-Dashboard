<?php

namespace App\Service;

use App\DTO\Dashboard\ContactDto;

interface ContactProviderInterface
{
    public function getContact(): ContactDto;
}