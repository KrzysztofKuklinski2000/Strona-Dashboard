<?php
declare(strict_types=1);

namespace App\Service\Dashboard;

use App\DTO\Dashboard\GalleryCategory\CreateGalleryCategoryDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\NotFoundException;
use App\Exception\ServiceException;
use App\Service\Dashboard\Contracts\GalleryCategoryManagementServiceInterface;
use App\Service\Dashboard\Traits\PositionableTrait;

class GalleryCategoryService extends AbstractDashboardService implements GalleryCategoryManagementServiceInterface
{
    use PositionableTrait;
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

    public function existsBySlug(string $slug): bool {
        return $this->repository->existsBySlug($slug);
    }
}