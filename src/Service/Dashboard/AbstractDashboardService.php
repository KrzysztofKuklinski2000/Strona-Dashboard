<?php

namespace App\Service\Dashboard;

use App\Exception\NotFoundException;
use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Repository\DashboardRepository;

abstract class AbstractDashboardService implements SharedGetDataServiceInterface {
  protected const TABLES_WITHOUT_POSITION = ['subscribers'];

  public function __construct(protected DashboardRepository $repository) {}

    /**
     * @throws ServiceException
     * @throws NotFoundException
     */
    public function getPost(int $id, string $table): ?array
  {
    try {
      return $this->repository->getPost($id, $table);
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

  protected function create(string $table, array $data): void
  {
    try {
      $this->repository->beginTransaction();
      if (!in_array($table, static::TABLES_WITHOUT_POSITION)) {
        $this->repository->incrementPosition($table);
      }
      $this->repository->create($data, $table);
      $this->repository->commit();
    } catch (RepositoryException $e) {
      $this->repository->rollBack();
      throw new ServiceException("Nie udało się utworzyć posta", 500, $e);
    }
  }

  protected function edit(string $table, array $data): void
  {
    try {
      $this->repository->edit($table, $data);
    } catch (RepositoryException $e) {
      throw new ServiceException("Nie udało się edytować", 500, $e);
    }
  }

  protected function delete(string $table, int $id): void
  {
    try {
      $this->repository->beginTransaction();
      $currentPost = $this->repository->getPost($id, $table);
      $this->repository->delete($id, $table);

      if (!in_array($table, static::TABLES_WITHOUT_POSITION)) {
        
        $this->repository->decrementPosition($table, (int) $currentPost['position']);
      }
      
      $this->repository->commit();
    } catch (RepositoryException $e) {
      $this->repository->rollBack();
      throw new ServiceException("Nie udało się usunąć posta", 500, $e);
    }
  }

  protected function published(string $table, array $data): void
  {
    try {
      $this->repository->published($data, $table);
    } catch (RepositoryException $e) {
      throw new ServiceException("Nie udało się zmienić statusu", 500, $e);
    }
  }

  protected function move(string $table, array $data): void
  {
    try {
      $this->repository->beginTransaction();

      $currentPost = $this->repository->getPost($data['id'], $table);

      $stmt = $this->repository->getPostByPosition(
        $table,
        $data['dir'] === 'up' ? (int) $currentPost['position'] - 1 : (int) $currentPost['position'] + 1,
      );

      if ($stmt) {
        $this->repository->movePosition($table, [':pos' => (int) $stmt['position'], ':id' => $currentPost['id']]);
        $this->repository->movePosition($table, [':pos' => (int) $currentPost['position'], ':id' => $stmt['id']]);
      }

      $this->repository->commit();
    } catch (RepositoryException $e) {
      $this->repository->rollBack();
      throw new ServiceException("Nie udało się zmienić pozycji", 500, $e);
    }
  }
}