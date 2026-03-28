<?php

namespace App\Service\Dashboard\Traits;

trait CanDelete
{
    protected function delete(string $table, int $id): void
    {
        $this->execute(fn() => $this->repository->delete($table, $id),
            "Nie udało się usunąć"
        );
    }
}