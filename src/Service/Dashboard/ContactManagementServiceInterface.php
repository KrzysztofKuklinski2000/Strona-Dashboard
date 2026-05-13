<?php

declare(strict_types=1);

namespace App\Service\Dashboard;

use App\DTO\Dashboard\ContactDto;

/**
 * Interfejs definiujący operacje wyłącznie dla modułu Aktualności.
 */
interface ContactManagementServiceInterface extends SharedGetDataServiceInterface
{
    /**
     * Pobiera wszystkie wpisy opłat.
     * @return ContactDto
     */
  public function getContact(): ContactDto;

    /**
     * Aktualizuje istniejący wpis opłat.
     * @param ContactDto $data Nowe dane z formularza.
     * @return void
     */
  public function updateContact(ContactDto $contactDto): void;
}
