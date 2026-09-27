<?php
declare(strict_types=1);

namespace App\Controller\Dashboard;

use App\Core\ContextController;
use App\Service\Dashboard\Contracts\GalleryCategoryManagementServiceInterface;

class GalleryCategoryController extends AbstractDashboardController
{
    public function __construct(
        private readonly GalleryCategoryManagementServiceInterface $categoryService,
        ContextController                       $contextController
    )
    {
        parent::__construct($contextController);
    }

    public function indexAction(): void
    {
        $this->renderPage([
            'page' => 'gallery/category/index',
            'data' => $this->categoryService->getAllCategories(),
        ]);
    }
}