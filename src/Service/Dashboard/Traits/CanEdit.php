<?php

namespace App\Service\Dashboard\Traits;

use App\DTO\DataTransferObjectInterface;
use App\Exception\RepositoryException;
use App\Exception\ServiceException;

trait CanEdit
{
    /**
     * @throws ServiceException
     */
    protected function edit(string $table, DataTransferObjectInterface $data): void
    {
        try {
            $this->repository->edit($table, $data);
        } catch (RepositoryException $e) {
            throw new ServiceException("Błąd edycji", 500, $e);
        }
    }
}