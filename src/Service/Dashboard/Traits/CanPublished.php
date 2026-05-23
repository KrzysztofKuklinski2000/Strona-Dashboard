<?php

namespace App\Service\Dashboard\Traits;

use App\DTO\DataTransferObjectInterface;
use App\Exception\RepositoryException;
use App\Exception\ServiceException;

trait CanPublished
{
    /**
     * @throws ServiceException
     */
    protected function published(string $table, DataTransferObjectInterface $data): void
    {
        try {
            $this->repository->published($table, $data);
        } catch (RepositoryException $e) {
            throw new ServiceException("Błąd zmiany statusu", 500, $e);
        }
    }
}