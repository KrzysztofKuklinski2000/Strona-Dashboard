<?php
declare(strict_types=1);

namespace App\Controller\Dashboard;

use App\Controller\Dashboard\Traits\HasSingleData;
use App\Core\ContextController;
use App\Exception\NotFoundException;
use App\Service\Dashboard\Contracts\GalleryCategoryManagementServiceInterface;

class GalleryCategoryController extends AbstractDashboardController
{
    use HasSingleData;

    public function __construct(
        private readonly GalleryCategoryManagementServiceInterface $service,
        ContextController                                          $contextController
    )
    {
        parent::__construct($contextController);
    }

    public function indexAction(): void
    {
        $this->renderPage([
            'page' => 'gallery/category/index',
            'data' => $this->service->getAllCategories(),
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function showAction(): void
    {
        $this->renderPage([
            'page' => 'gallery/category/show',
            'data' => $this->getSingleData(),
        ]);
    }
}