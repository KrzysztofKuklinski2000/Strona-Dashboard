<?php

namespace App\Service\Dashboard\Contracts;

use App\DTO\DataTransferObjectInterface;

/**
 * Interfejs definiujący operacje wspólne dla wszystkich modułów.
 */
interface SharedGetDataServiceInterface {
  public function getPost(int $id): DataTransferObjectInterface;
}