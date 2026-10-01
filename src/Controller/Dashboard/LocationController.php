<?php

namespace App\Controller\Dashboard;

use App\Core\ContextController;
use App\Service\Dashboard\Contracts\LocationManagementServiceInterface;

class LocationController extends AbstractDashboardController
{
    public function __construct(
        private readonly LocationManagementServiceInterface $service,
        ContextController $contextController
    )
    {
        parent::__construct($contextController);
    }

    public function indexAction(): void {
        $this->renderPage([
            'page' => 'timetable/location/index',
            'data' => $this->service->getAllLocations(),
        ]);
    }
}