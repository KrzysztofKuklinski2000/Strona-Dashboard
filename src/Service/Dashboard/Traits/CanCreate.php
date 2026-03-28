<?php

namespace App\Service\Dashboard\Traits;

trait CanCreate
{
    protected function simpleCreate(string $table, array $data): void {
        $this->execute(fn() => $this->repository->create($table, $data),
            "Błąd tworzenia"
        );
    }
}