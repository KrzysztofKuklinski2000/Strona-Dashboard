<?php

namespace App\Controller\Dashboard;

use App\Controller\Dashboard\Traits\HasSingleData;
use App\Core\ContextController;
use App\Exception\NotFoundException;
use App\Service\Dashboard\Contracts\LocationManagementServiceInterface;

class LocationController extends AbstractDashboardController
{
    use HasSingleData;
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

    /**
     * @throws NotFoundException
     */
    public function showAction(): void{
        $this->renderPage([
            'page' => 'timetable/location/show',
            'data' => $this->getSingleData(),
        ]);
    }
}