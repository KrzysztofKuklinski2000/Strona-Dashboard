<?php
declare(strict_types=1);

namespace App\Service\Dashboard;

use App\Exception\ServiceException;
use App\Service\Dashboard\Contracts\GalleryCategoryManagementServiceInterface;

class GalleryCategoryService extends AbstractDashboardService implements GalleryCategoryManagementServiceInterface
{
    private const TABLE = 'gallery_categories';


    /**
     * @throws ServiceException
     */
    public function getAllCategories(): array {
        return $this->getAll(self::TABLE);
    }
}