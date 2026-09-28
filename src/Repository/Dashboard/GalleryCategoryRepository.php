<?php
declare(strict_types=1);

namespace App\Repository\Dashboard;

use App\DTO\Dashboard\GalleryCategory\GalleryCategoryDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\RepositoryException;
use App\Repository\Dashboard\Traits\CanCreate;
use App\Repository\Dashboard\Traits\CanDelete;
use App\Repository\Dashboard\Traits\CanEdit;
use App\Repository\Dashboard\Traits\CanPublished;
use App\Repository\Dashboard\Traits\Positionable;

class GalleryCategoryRepository extends BaseDashboardRepository
{
    use Positionable;
    use CanCreate;
    use CanEdit;
    use CanDelete;
    use CanPublished;

    protected function mapToDto(array $data): DataTransferObjectInterface
    {
        return GalleryCategoryDto::fromArray($data);
    }

    /**
     * @throws RepositoryException
     */
    public function existsBySlug(string $slug, ?int $excludedId = null): bool
    {
        $sql = '
        SELECT EXISTS(
            SELECT 1
            FROM gallery_categories
            WHERE slug = :slug
    ';

        $params = [
            ':slug' => $slug,
        ];

        if ($excludedId !== null) {
            $sql .= ' AND id != :excluded_id';
            $params[':excluded_id'] = $excludedId;
        }

        $sql .= ')';

        try {
            return (bool)$this->runQuery($sql, $params)->fetchColumn();
        } catch (RepositoryException $e) {
            throw new RepositoryException('Nie udało się pobrać slug', 500, $e);
        }
    }

    /**
     * @throws RepositoryException
     */
    public function getActiveCategories(): array
    {
        try {
            $sql = 'SELECT * FROM gallery_categories WHERE status = 1 ORDER BY position ASC';

            $categories = $this->runQuery($sql)->fetchAll();
        } catch (RepositoryException $e) {
            throw new RepositoryException('Nie udało się pobrać aktywnych kategorii', 500, $e);
        }

        return array_map(fn($category) => GalleryCategoryDto::fromArray($category), $categories);
    }
}