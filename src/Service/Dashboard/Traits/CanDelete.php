<?php

namespace App\Service\Dashboard\Traits;

trait CanDelete
{
    protected function simpleDelete(string $table, int $id): void
    {
        $this->execute(fn() => $this->repository->delete($id, $table),
            "Nie udało się usunąć"
        );
    }
}