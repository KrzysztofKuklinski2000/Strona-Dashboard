<?php

namespace App\Service\Dashboard;

use App\Core\FileHandler;
use App\DTO\Dashboard\CreateGalleryDto;
use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\FileException;
use App\Exception\NotFoundException;
use App\Exception\ServiceException;
use App\Repository\Dashboard\GalleryRepository;
use App\Service\Dashboard\Traits\CanEdit;
use App\Service\Dashboard\Traits\CanPublished;
use App\Service\Dashboard\Traits\PositionableTrait;

/**
 * @property GalleryRepository $repository
 */
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
    public function getAllGallery(): array
    {
        return $this->getAll(self::TABLE);
    }

    /**
     * @throws ServiceException
     * @throws NotFoundException
     */
    public function getPost(string $table, int $id): ?DataTransferObjectInterface
    {
        return $this->getRow($table, $id);
    }

    /**
     * @throws ServiceException
     */
    public function updateGallery(DataTransferObjectInterface $galleryDto): void
    {
        $this->edit(self::TABLE, $galleryDto);
    }

    /**
     * @throws ServiceException
     */
    public function createGallery(DataTransferObjectInterface $galleryDto): void
    {
        try {

            /** @var CreateGalleryDto $galleryDto */
            $imageName = $this->fileHandler->uploadImage($galleryDto->imageName);

            $updatedDto = CreateGalleryDto::fromArray([
                'category' => $galleryDto->category,
                'description' => $galleryDto->description,
                'image_name' => $imageName,
                'created_at' => $galleryDto->createdAt,
                'updated_at' => $galleryDto->updatedAt,
            ]);

            $this->create(self::TABLE, $updatedDto);

        } catch (FileException $e) {
            throw new ServiceException("Nie udało się wgrać zdjęcia na serwer", 500, $e);
        }
    }

    /**
     * @throws ServiceException
     */
    public function publishedGallery(DataTransferObjectInterface $galleryDto): void
    {
        $this->published(self::TABLE, $galleryDto);
    }

    public function deleteGallery(int $id): void
    {
        $this->delete(self::TABLE, $id);
    }

    public function moveGallery(ChangePositionDto $changePositionDto): void
    {
        $this->move(self::TABLE, $changePositionDto);
    }
}