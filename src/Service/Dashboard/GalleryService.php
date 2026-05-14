<?php

namespace App\Service\Dashboard;

use App\Core\FileHandler;
use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\Dashboard\GalleryDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\FileException;
use App\Exception\NotFoundException;
use App\Exception\RepositoryException;
use App\Exception\ServiceException;
use App\Repository\Dashboard\GalleryRepository;
use App\Service\Dashboard\Traits\CanEdit;
use App\Service\Dashboard\Traits\CanPublished;
use App\Service\Dashboard\Traits\PositionableTrait;

class GalleryService extends AbstractDashboardService implements GalleryManagementServiceInterface
{
    use PositionableTrait, CanPublished, CanEdit;

    private const TABLE = 'gallery';

    public function __construct(
        GalleryRepository            $repository,
        private readonly FileHandler $fileHandler
    )
    {
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
        } catch (RepositoryException|FileException $e) {
            $this->repository->rollBack();
            throw new ServiceException("Nie udało się dodać zdjęcia", 500, $e);
        }
    }

    /**
     * @throws ServiceException
     */
    public function getAllGallery(): array
    {
        $data = $this->getAll(self::TABLE);

        return array_map(fn(array $row) => GalleryDto::fromArray($row), $data);
    }

    /**
     * @throws ServiceException
     * @throws NotFoundException
     */
    public function getPost(string $table, int $id): ?DataTransferObjectInterface
    {
        $data = $this->getRow($table, $id);

        return $data ? GalleryDto::fromArray($data) : null;
    }

    /**
     * @throws ServiceException
     */
    public function updateGallery(DataTransferObjectInterface $galleryDto): void
    {
        $this->edit(self::TABLE, $galleryDto->toArray());
    }

    /**
     * @throws ServiceException
     */
    public function createGallery(DataTransferObjectInterface $galleryDto): void
    {
        $this->addImage($galleryDto->toArray());
    }

    /**
     * @throws ServiceException
     */
    public function publishedGallery(DataTransferObjectInterface $galleryDto): void
    {
        $this->published(self::TABLE, $galleryDto->toArray());
    }

    public function deleteGallery(int $id): void
    {
        $this->delete(self::TABLE, $id);
    }

    public function moveGallery(ChangePositionDto $changePositionDto): void
    {
        $this->move(self::TABLE, $changePositionDto->toArray());
    }


}
