<?php

namespace App\Service\Dashboard;

use App\Exception\NotFoundException;
use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Repository\Dashboard\BaseDashboardRepository;

abstract class AbstractDashboardService implements SharedGetDataServiceInterface {
  public function __construct(protected BaseDashboardRepository $repository) {}

    /**
     * @throws ServiceException
     * @throws NotFoundException
     */
    public function getPost(string $table, int $id): ?array
  {
    try {
      return $this->repository->getPost($table, $id);
    } catch (RepositoryException $e) {
      throw new ServiceException("Nie udało się pobrać posta", 500, $e);
    }
  }

    /**
     * @throws ServiceException
     */
    protected function getAll(string $table): array
  {
    try {
      return $this->repository->getDashboardData($table);
    } catch (RepositoryException $e) {
      throw new ServiceException("Nie udało się pobrać postów", 500, $e);
    }
  }

    /**
     * @throws ServiceException
     */
    protected function execute(callable $action, string $errorMessage): void {
      try {
          $this->repository->beginTransaction();
          $action();
          $this->repository->commit();
      } catch(RepositoryException $e) {
          $this->repository->rollBack();
          throw new ServiceException($errorMessage, 500, $e);
      }
  }
}