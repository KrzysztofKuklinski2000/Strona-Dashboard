<?php

namespace App\Service\Dashboard\Traits;

trait PositionableTrait
{
    protected function move(string $table, array $data): void {
        $this->execute(function () use ($table, $data) {
            $current = $this->repository->getPost($data['id'], $table);

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

    protected function createWithPosition(string $table, array $data): void {
        $this->execute(function () use ($table, $data) {
            $this->repository->incrementPosition($table);
            $this->repository->create($table, $data);
        }, "Błąd tworzenia pozycji");
    }

    protected function deleteWithPosition(string $table, int $id):void {
        $this->execute(function () use ($table, $id) {
            $currentPost = $this->repository->getPost($id, $table);
            $this->repository->delete($id, $table);
            $this->repository->decrementPosition($table, (int) $currentPost['position']);
        }, "Błąd usuwania pozycji");
    }
}