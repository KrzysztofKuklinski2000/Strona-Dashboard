<?php

namespace App\Service\Dashboard\Traits;

trait PositionableTrait
{
    protected function move(string $table, array $data): void {
        $this->execute(function () use ($table, $data) {
            $current = $this->repository->getPost($table, $data['id']);

            $targetPos = $data['dir'] === 'up' ? (int) $current['position'] - 1 : (int) $current['position'] + 1;
            $stmt = $this->repository->getPostByPosition(
                $table,
                $targetPos,
            );

            if ($stmt) {
                $this->repository->movePosition($table, [':pos' => (int) $stmt['position'], ':id' => $current['id']]);
                $this->repository->movePosition($table, [':pos' => (int) $current['position'], ':id' => $stmt['id']]);
            }
        }, "Błąd zmiany pozycji");
    }

    protected function create(string $table, array $data): void {
        $this->execute(function () use ($table, $data) {
            $this->repository->incrementPosition($table);
            $this->repository->create($table, $data);
        }, "Błąd tworzenia pozycji");
    }

    protected function delete(string $table, int $id):void {
        $this->execute(function () use ($table, $id) {
            $currentPost = $this->repository->getPost($table, $id);
            $this->repository->delete($table, $id);
            $this->repository->decrementPosition($table, (int) $currentPost['position']);
        }, "Błąd usuwania pozycji");
    }
}