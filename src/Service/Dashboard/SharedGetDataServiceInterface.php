<?php

namespace App\Service\Dashboard;

use App\DTO\DataTransferObjectInterface;

/**
 * Interfejs definiujący operacje wspólne dla wszystkich modułów.
 */
interface SharedGetDataServiceInterface {
  public function getPost(string $table, int $id): ?DataTransferObjectInterface;
}