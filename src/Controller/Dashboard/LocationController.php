<?php

namespace App\Controller\Dashboard;

use App\Controller\Dashboard\Traits\HasSingleData;
use App\Controller\Dashboard\Traits\HasStoreAction;
use App\Core\ContextController;
use App\DTO\Dashboard\Location\CreateLocationDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\NotFoundException;
use App\Mapper\Dashboard\LocationRequestMapper;
use App\Service\Dashboard\Contracts\LocationManagementServiceInterface;

class LocationController extends AbstractDashboardController
{
    use HasSingleData;
    use HasStoreAction;

    public function __construct(
        private readonly LocationManagementServiceInterface $service,
        private readonly LocationRequestMapper $locationRequestMapper,
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

    public function createAction(): void {
        $this->renderPage([
            'page' => 'timetable/location/create',
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

    protected function getModuleName(): string
    {
        return 'timetable/location';
    }

    protected function getDataToCreate(): DataTransferObjectInterface
    {
        return $this->locationRequestMapper->mapCreate();
    }

    protected function handleCreate(DataTransferObjectInterface $data): void
    {
        /** @var CreateLocationDto $data */
        $this->service->createLocation($data);
    }
}