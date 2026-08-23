<?php

declare(strict_types=1);

namespace App\Service\Dashboard\Contracts;

use App\DTO\DataTransferObjectInterface;

/**
 * Interfejs definiujący operacje wspólne dla wszystkich modułów.
 */
interface SharedGetDataServiceInterface
{
    public function getPost(int $id): DataTransferObjectInterface;
}
