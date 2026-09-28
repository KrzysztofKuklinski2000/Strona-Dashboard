<?php

declare(strict_types=1);

namespace App\Repository\Dashboard;

use App\DTO\Dashboard\Gallery\GalleryDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\RepositoryException;
use App\Repository\Dashboard\Traits\CanCreate;
use App\Repository\Dashboard\Traits\CanDelete;
use App\Repository\Dashboard\Traits\CanEdit;
use App\Repository\Dashboard\Traits\CanPublished;
use App\Repository\Dashboard\Traits\Positionable;
use PDO;

class GalleryRepository extends BaseDashboardRepository
{
    use Positionable;
    use CanPublished;
    use CanEdit;
    use CanDelete;
    use CanCreate;

    protected function mapToDto(array $data): DataTransferObjectInterface
    {
        return GalleryDto::fromArray($data);
    }

    /**
     * @throws RepositoryException
     */
    public function getCategoryIdsForGallery(int $galleryId): array
    {
        try {
            $sql = 'SELECT category_id FROM gallery_category WHERE gallery_id = :gallery_id';

            $categoryIds = $this->runQuery($sql,
                [':gallery_id' => [$galleryId, PDO::PARAM_INT]]
            )->fetchAll(PDO::FETCH_COLUMN);


            return array_map('intval', $categoryIds);
        } catch (RepositoryException $e) {
            throw new RepositoryException(
                'Nie udało się pobrać kategorii przypisanych do zdjęcia',
                500,
                $e
            );
        }
    }

    /**
     * @throws RepositoryException
     */
    public function assignCategories(int $galleryId, array $categories): void {
        foreach (array_unique($categories) as $categoryId) {
            $this->runQuery('
                    INSERT INTO gallery_category (gallery_id, category_id) 
                    VALUES (:gallery_id, :category_id)',
                [
                    ':gallery_id' => [$galleryId, PDO::PARAM_INT],
                    ':category_id' => [$categoryId, PDO::PARAM_INT],
                ]
            );
        }
    }

    /**
     * @throws RepositoryException
     */
    public function replaceCategories(int $galleryId, array $categories): void {
        try {
            $this->runQuery('DELETE FROM gallery_category WHERE gallery_id = :gallery_id', [
                ':gallery_id' => [$galleryId, PDO::PARAM_INT],
            ]);

            $this->assignCategories($galleryId, $categories);
        } catch (RepositoryException $e) {
            throw new RepositoryException('Nie udało się zamienić kategorii', 500, $e);
        }
    }
}
