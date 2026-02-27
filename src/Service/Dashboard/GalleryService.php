<?php

namespace App\Service\Dashboard;

use App\Core\FileHandler;
use App\Exception\FileException;
use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Repository\DashboardRepository;

class GalleryService extends AbstractDashboardService implements GalleryManagementServiceInterface
{
  private const TABLE = 'gallery';

  public function __construct(
    DashboardRepository $repository,
    private FileHandler $fileHandler
  ) {
    parent::__construct($repository);
  }

  private function addImage(array $data): void
  {
    try {
      $this->repository->beginTransaction();
      $imageName = $this->fileHandler->uploadImage($data['image_name']);
      $this->repository->incrementPosition('gallery');
      $data['image_name'] = $imageName;
      $this->repository->addImage($data);
      $this->repository->commit();
    } catch (RepositoryException | FileException $e) {
      $this->repository->rollBack();
      throw new ServiceException("Nie udało się dodać zdjęcia", 500, $e);
    }
  }

  public function getAllGallery(): array
  {
    return $this->getAll(self::TABLE);
  }

  public function updateGallery(array $data): void
  {
    $this->edit(self::TABLE, $data);
  }

  public function createGallery(array $data): void
  {
    $this->addImage($data);
  }

  public function publishedGallery(array $data): void
  {
    $this->published(self::TABLE, $data);
  }

  public function deleteGallery(int $id): void
  {
    $this->delete(self::TABLE, $id);
  }

  public function moveGallery(array $data): void
  {
    $this->move(self::TABLE, $data);
  }
}
