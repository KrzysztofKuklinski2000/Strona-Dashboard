<?php 

namespace App\Service\Dashboard\Traits;

use App\Exception\RepositoryException;
use App\Exception\ServiceException;

trait StandardCrudTrait {
    protected function edit(string $table, array $data): void
    {
        try {
            $this->repository->edit($table, $data);
        } catch (RepositoryException $e) {
            throw new ServiceException("Błąd edycji", 500, $e);
        }
    }

    protected function published(string $table, array $data): void
    {
        try {
            $this->repository->published($table, $data);
        } catch (RepositoryException $e) {
            throw new ServiceException("Błąd zmiany statusu", 500, $e);
        }
    }

    protected function simpleDelete(string $table, int $id): void
    {
        $this->execute(fn() => $this->repository->delete($id, $table), "Nie udało się usunąć");
    }
}