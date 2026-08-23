<?php

declare(strict_types=1);

namespace App\Service\Dashboard\Traits;

use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\ServiceException;

trait PositionableTrait
{
    /**
     * @throws ServiceException
     */
    protected function move(string $table, ChangePositionDto $data): void
    {
        $this->execute(function () use ($table, $data) {
            $current = $this->repository->getPost($table, $data->id);

            $targetPos = $data->dir === 'up' ? (int) $current->position - 1 : (int) $current->position + 1;
            $stmt = $this->repository->getPostByPosition($table, $targetPos);

            if ($stmt) {
                $this->repository->movePosition($table, $current->id, (int) $stmt->position);
                $this->repository->movePosition($table, $stmt->id, (int) $current->position);
            }
        }, "Błąd zmiany pozycji");
    }

    /**
     * @throws ServiceException
     */
    protected function create(
        string $table,
        DataTransferObjectInterface $data,
        int $position = 1,
    ): void {
        $this->execute(function () use ($table, $data, $position) {
            $this->repository->incrementPosition($table, $position);
            $this->repository->create($table, $data);
        }, "Błąd tworzenia pozycji");
    }

    /**
     * @throws ServiceException
     */
    protected function delete(string $table, int $id): void
    {
        $this->execute(function () use ($table, $id) {
            $currentPost = $this->repository->getPost($table, $id);
            $this->repository->delete($table, $id);
            $this->repository->decrementPosition($table, (int) $currentPost->position);
        }, "Błąd usuwania pozycji");
    }
}
