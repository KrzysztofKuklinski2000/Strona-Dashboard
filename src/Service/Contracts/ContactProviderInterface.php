<?php

namespace App\Service\Contracts;

use App\DTO\Dashboard\ContactDto;

interface ContactProviderInterface
{
    /**
     *  Pobiera dane kontaktowe
     *  @return ContactDto
     */
    public function getContact(): ContactDto;
}