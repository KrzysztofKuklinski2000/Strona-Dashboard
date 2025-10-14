<?php

namespace App\Service\Dashboard;

/**
 * Interfejs definiujący operacje wspólne dla wszystkich modułów.
 */
interface SharedGetDataServiceInterface {
  public function getPost(int $id, string $table): ?array;
}