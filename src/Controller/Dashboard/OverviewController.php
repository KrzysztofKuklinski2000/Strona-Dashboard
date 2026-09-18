<?php
declare(strict_types=1);

namespace App\Controller\Dashboard;

use App\Core\ContextController;
use App\Exception\ServiceException;
use App\Service\Dashboard\OverviewService;

class OverviewController extends AbstractDashboardController
{
    public function __construct(
        private readonly OverviewService $overviewService,
        ContextController                $contextController,

    )
    {
        parent::__construct($contextController);
    }

    /**
     * @throws ServiceException
     */
    public function indexAction(): void
    {
        $this->renderPage([
            'page' => 'overview/index',
            'data' => $this->overviewService->getOverviewData(),
        ]);
    }
}