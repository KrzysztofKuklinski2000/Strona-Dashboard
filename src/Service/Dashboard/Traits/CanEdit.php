<?php

namespace App\Service\Dashboard\Traits;

use App\Exception\RepositoryException;
use App\Exception\ServiceException;

trait CanEdit
{
    /**
     * @throws ServiceException
     */
    protected function edit(string $table, array $data): void
    {
        try {
            $this->repository->edit($table, $data);
        } catch (RepositoryException $e) {
            throw new ServiceException("Błąd edycji", 500, $e);
        }
    }
}