<?php
declare(strict_types=1);

namespace App\Repository\Dashboard;

use App\DTO\Dashboard\GalleryCategory\GalleryCategoryDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\RepositoryException;
use App\Repository\Dashboard\Traits\CanCreate;
use App\Repository\Dashboard\Traits\Positionable;

class GalleryCategoryRepository extends BaseDashboardRepository
{
    use Positionable;
    use CanCreate;

    protected function mapToDto(array $data): DataTransferObjectInterface
    {
       return GalleryCategoryDto::fromArray($data);
    }

    /**
     * @throws RepositoryException
     */
    public function existsBySlug(string $slug): bool
    {
        $statement = $this->runQuery(
            'SELECT EXISTS(
                SELECT 1
                FROM gallery_categories
                WHERE slug = :slug
            )',
            [':slug' => $slug]
        );

        return (bool) $statement->fetchColumn();
    }
}