<?php

declare(strict_types=1);

namespace App\Service\Dashboard\Contracts;

use App\DTO\Dashboard\ContactDto;
use App\Service\Contracts\ContactProviderInterface;

/**
 * Interfejs definiujący operacje wyłącznie dla modułu Kontaktu.
 */
interface ContactManagementServiceInterface extends ContactProviderInterface
{
    /**
     * Aktualizuje istniejący wpis Kontaktu.
     * @param ContactDto $contactDto
     * @return void
     */
    public function updateContact(ContactDto $contactDto): void;
}
