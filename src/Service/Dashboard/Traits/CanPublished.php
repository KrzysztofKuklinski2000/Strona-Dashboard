<?php

namespace App\Service\Dashboard\Traits;

use App\Exception\RepositoryException;
use App\Exception\ServiceException;

trait CanPublished
{
    /**
     * @throws ServiceException
     */
    protected function published(string $table, array $data): void
    {
        try {
            $this->repository->published($table, $data);
        } catch (RepositoryException $e) {
            throw new ServiceException("Błąd zmiany statusu", 500, $e);
        }
    }
}