<?php

declare(strict_types=1);

namespace App\Service\Dashboard;

use App\Core\FileHandler;
use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\Dashboard\CreateGalleryDto;
use App\DTO\Dashboard\GalleryDto;
use App\DTO\Dashboard\PublishedDto;
use App\DTO\Dashboard\UpdateGalleryDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\FileException;
use App\Exception\NotFoundException;
use App\Exception\ServiceException;
use App\Repository\Dashboard\GalleryRepository;
use App\Service\Dashboard\Contracts\GalleryManagementServiceInterface;
use App\Service\Dashboard\Traits\CanEdit;
use App\Service\Dashboard\Traits\CanPublished;
use App\Service\Dashboard\Traits\PositionableTrait;

/**
 * @property GalleryRepository $repository
 */
class GalleryService extends AbstractDashboardService implements GalleryManagementServiceInterface
{
    use PositionableTrait;
    use CanPublished;
    use CanEdit;

    private const TABLE = 'gallery';

    public function __construct(
        GalleryRepository            $repository,
        private readonly FileHandler $fileHandler
    ) {
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
    public function getPost(int $id): DataTransferObjectInterface
    {
        return $this->getRow(self::TABLE, $id);
    }

    /**
     * @throws ServiceException
     * @throws NotFoundException
     */
    public function updateGallery(UpdateGalleryDto $galleryDto): void
    {
        if (!is_array($galleryDto->imageName)) {
            $this->edit(self::TABLE, $galleryDto);
            return;
        }

        /** @var GalleryDto $oldGallery */
        $oldGallery = $this->getPost($galleryDto->id);

        try {
            $newImageName = $this->fileHandler->uploadImage(
                $galleryDto->imageName,
            );
        } catch (FileException $e) {
            throw new ServiceException(
                'Nie udało się wgrać nowego zdjęcia.',
                500,
                $e,
            );
        }

        $updatedDto = UpdateGalleryDto::fromArray([
            'id' => $galleryDto->id,
            'category' => $galleryDto->category,
            'description' => $galleryDto->description,
            'image_name' => $newImageName,
            'updated_at' => $galleryDto->updatedAt,
        ]);

        try {
            $this->edit(self::TABLE, $updatedDto);
        } catch (ServiceException $e) {
            try {
                $this->fileHandler->deleteImage($newImageName);
            } catch (FileException $cleanupException) {
                throw new ServiceException(
                    'Nie udało się zapisać zmian ani usunąć nowego pliku.',
                    500,
                    $cleanupException,
                );
            }

            throw $e;
        }

        try {
            $this->fileHandler->deleteImage($oldGallery->imageName);
        } catch (FileException $e) {
            throw new ServiceException(
                'Zmiany zapisano, ale nie udało się usunąć starego zdjęcia.',
                500,
                $e,
            );
        }
    }
    /**
     * @throws ServiceException
     */
    public function createGallery(CreateGalleryDto $galleryDto): void
    {
        try {
            $imageName = $this->fileHandler->uploadImage($galleryDto->imageName);
        } catch (FileException $e) {
            throw new ServiceException("Nie udało się wgrać zdjęcia na serwer", 500, $e);
        }

        $updatedDto = CreateGalleryDto::fromArray([
            'category' => $galleryDto->category,
            'description' => $galleryDto->description,
            'image_name' => $imageName,
            'created_at' => $galleryDto->createdAt,
            'updated_at' => $galleryDto->updatedAt,
        ]);

        try {
            $this->create(self::TABLE, $updatedDto);
        } catch (ServiceException $e) {
            try {
                $this->fileHandler->deleteImage($imageName);
            } catch (FileException $e) {
                throw new ServiceException(
                    'Nie udało się zapisać wpisu galerii ani usunąć przesłanego pliku.',
                    500,
                    $e
                );
            }

            throw $e;
        }
    }

    /**
     * @throws ServiceException
     */
    public function publishedGallery(PublishedDto $galleryDto): void
    {
        $this->published(self::TABLE, $galleryDto);
    }

    /**
     * @throws ServiceException
     * @throws NotFoundException
     */
    public function deleteGallery(int $id): void
    {
        /** @var GalleryDto $galleryPost */
        $galleryPost = $this->getPost($id);

        $this->delete(self::TABLE, $id);

        try {
            $this->fileHandler->deleteImage($galleryPost->imageName);
        } catch (FileException $e) {
            throw new ServiceException(
                'Wpis został usunięty, ale nie udało się usunąć pliku obrazu.',
                500,
                $e
            );
        }


    }

    public function moveGallery(ChangePositionDto $changePositionDto): void
    {
        $this->move(self::TABLE, $changePositionDto);
    }
}
