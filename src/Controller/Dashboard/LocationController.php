<?php

namespace App\Controller\Dashboard;

use App\Controller\Dashboard\Traits\HasDeleteAction;
use App\Controller\Dashboard\Traits\HasSingleData;
use App\Controller\Dashboard\Traits\HasStoreAction;
use App\Controller\Dashboard\Traits\HasUpdateAction;
use App\Core\ContextController;
use App\DTO\Dashboard\Location\CreateLocationDto;
use App\DTO\Dashboard\Location\UpdateLocationDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\NotFoundException;
use App\Exception\ServiceException;
use App\Mapper\Dashboard\LocationRequestMapper;
use App\Service\Dashboard\Contracts\LocationManagementServiceInterface;

class LocationController extends AbstractDashboardController
{
    use HasSingleData;
    use HasStoreAction;
    use HasUpdateAction;
    use HasDeleteAction;

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

    /**
     * @throws NotFoundException
     */
    public function editAction(): void{
        $this->renderPage([
            'page' => 'timetable/location/edit',
            'data' => $this->getSingleData(),
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function confirmDeleteAction(): void {
        $this->renderPage([
            'page' => 'timetable/location/delete',
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

    protected function getDataToUpdate(): DataTransferObjectInterface
    {
        return $this->locationRequestMapper->mapUpdate();
    }

    protected function getDataToDelete(): ?int
    {
        return $this->locationRequestMapper->mapDelete();
    }

    protected function handleCreate(DataTransferObjectInterface $data): void
    {
        /** @var CreateLocationDto $data */
        $this->service->createLocation($data);
    }

    protected function handleUpdate(DataTransferObjectInterface $data): void
    {
        /** @var UpdateLocationDto $data */
        $this->service->updateLocation($data);
    }

    /**
     * @throws ServiceException
     */
    protected function handleDelete(int $id): void {
        try {
            $this->service->deleteLocation($id);
        }catch (ServiceException $e){
            if ($e->getCode() !== 409) {
                throw $e;
            }

            $this->sessionManager->setFlash('warning', $e->getMessage());

            $this->redirect(
                "{$this->contextController->config->getDashboardRoute()}/{$this->getModuleName()}"
            );
        }
    }
}