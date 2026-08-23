<?php

declare(strict_types=1);

namespace App\Service\Dashboard\Traits;

use App\DTO\DataTransferObjectInterface;
use App\Exception\ServiceException;

trait CanCreate
{
    /**
     * @throws ServiceException
     */
    protected function create(string $table, DataTransferObjectInterface $data): void
    {
        $this->execute(
            fn () => $this->repository->create($table, $data),
            "Błąd tworzenia"
        );
    }
}
