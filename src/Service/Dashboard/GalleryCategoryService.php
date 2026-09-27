<?php
declare(strict_types=1);

namespace App\Service\Dashboard;

use App\DTO\Dashboard\ChangePositionDto;
use App\DTO\Dashboard\GalleryCategory\CreateGalleryCategoryDto;
use App\DTO\Dashboard\GalleryCategory\UpdateGalleryCategoryDto;
use App\DTO\Dashboard\PublishedDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\NotFoundException;
use App\Exception\ServiceException;
use App\Service\Dashboard\Contracts\GalleryCategoryManagementServiceInterface;
use App\Service\Dashboard\Traits\CanEdit;
use App\Service\Dashboard\Traits\CanPublished;
use App\Service\Dashboard\Traits\PositionableTrait;

class GalleryCategoryService extends AbstractDashboardService implements GalleryCategoryManagementServiceInterface
{
    use PositionableTrait;
    use CanEdit;
    use CanPublished;
    private const TABLE = 'gallery_categories';


    /**
     * @throws ServiceException
     */
    public function getAllCategories(): array
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
     */
    public function createGalleryCategory(CreateGalleryCategoryDto $data): void {

        $this->create(self::TABLE, $data);
    }

    /**
     * @throws ServiceException
     */
    public function updateGalleryCategory(UpdateGalleryCategoryDto $data): void {
        $this->edit(self::TABLE, $data);
    }

    /**
     * @throws ServiceException
     */
    public function deleteGalleryCategory(int $id): void {
        $this->delete(self::TABLE, $id);
    }

    /**
     * @throws ServiceException
     */
    public function publishedGalleryCategory(PublishedDto $data): void {
        $this->published(self::TABLE, $data);
    }

    /**
     * @throws ServiceException
     */
    public function moveGalleryCategory(ChangePositionDto $changePositionDto): void
    {
        $this->move(self::TABLE, $changePositionDto);
    }

    public function existsBySlug(string $slug, ?int $excludedId = null): bool {
        return $this->repository->existsBySlug($slug, $excludedId);
    }
}