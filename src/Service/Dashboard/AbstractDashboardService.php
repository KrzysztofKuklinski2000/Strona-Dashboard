<?php

namespace App\Service\Dashboard;

use App\DTO\DataTransferObjectInterface;
use App\Exception\NotFoundException;
use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Repository\Dashboard\BaseDashboardRepository;
use Throwable;

abstract class AbstractDashboardService
{
    public function __construct(protected BaseDashboardRepository $repository)
    {
    }

    /**
     * @throws ServiceException
     * @throws NotFoundException
     */
    public function getRow(string $table, int $id): ?DataTransferObjectInterface
    {
        try {
            return $this->repository->getPost($table, $id);
        } catch (RepositoryException $e) {
            throw new ServiceException("Nie udało się pobrać posta", 500, $e);
        }
    }

    /**
     * @return DataTransferObjectInterface[]
     * @throws ServiceException
     */
    protected function getAll(string $table, string $orderBy = 'position'): array
    {
        try {
            return $this->repository->getDashboardData($table, $orderBy);
        } catch (RepositoryException $e) {
            throw new ServiceException("Nie udało się pobrać postów", 500, $e);
        }
    }

    /**
     * @throws ServiceException
     */
    protected function execute(callable $action, string $errorMessage): void
    {
        try {
            $this->repository->beginTransaction();
            $action();
            $this->repository->commit();
        } catch (Throwable $e) {
            $this->repository->rollBack();
            throw new ServiceException($errorMessage, 500, $e);
        }
    }
}