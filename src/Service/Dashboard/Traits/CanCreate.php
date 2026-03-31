<?php

namespace App\Service\Dashboard\Traits;

use App\Exception\ServiceException;

trait CanCreate
{
    /**
     * @throws ServiceException
     */
    protected function create(string $table, array $data): void {
        $this->execute(fn() => $this->repository->create($table, $data),
            "Błąd tworzenia"
        );
    }
}