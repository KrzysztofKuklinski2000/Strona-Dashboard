<?php
declare(strict_types=1);

namespace App\Controller\Dashboard;

class OverviewController extends AbstractDashboardController
{
    public function indexAction(): void
    {
        $this->renderPage([
            'page' => 'overview/index',
        ]);
    }

    protected function getModuleName(): string
    {
        return 'overview';
    }
}