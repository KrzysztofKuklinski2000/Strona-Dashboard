<?php

namespace App\Service\Dashboard;

use App\Core\FileHandler;
use App\Exception\FileException;
use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Repository\Dashboard\GalleryRepository;
use App\Service\Dashboard\Traits\CanEdit;
use App\Service\Dashboard\Traits\CanPublished;
use App\Service\Dashboard\Traits\PositionableTrait;

class GalleryService extends AbstractDashboardService implements GalleryManagementServiceInterface
{
    use PositionableTrait, CanPublished , CanEdit;
  private const TABLE = 'gallery';

  public function __construct(
    GalleryRepository $repository,
    private readonly FileHandler $fileHandler
  ) {
    parent::__construct($repository);
  }

    /**
     * @throws ServiceException
     */
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

    /**
     * @throws ServiceException
     */
    public function getAllGallery(): array
  {
    return $this->getAll(self::TABLE);
  }

    /**
     * @throws ServiceException
     */
    public function updateGallery(array $data): void
  {
    $this->edit(self::TABLE, $data);
  }

    /**
     * @throws ServiceException
     */
    public function createGallery(array $data): void
  {
    $this->addImage($data);
  }

    /**
     * @throws ServiceException
     */
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
