<?php

declare(strict_types=1);

namespace App\Controller\Dashboard;

use App\Controller\Dashboard\Traits\HasDeleteAction;
use App\Controller\Dashboard\Traits\HasPublishedAction;
use App\Controller\Dashboard\Traits\HasSingleData;
use App\Controller\Dashboard\Traits\HasStoreAction;
use App\Controller\Dashboard\Traits\HasUpdateAction;
use App\Core\ContextController;
use App\DTO\Dashboard\PublishedDto;
use App\DTO\Dashboard\Timetable\CreateTimetableDto;
use App\DTO\Dashboard\Timetable\TimetableDto;
use App\DTO\Dashboard\Timetable\UpdateTimetableDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\NotFoundException;
use App\Exception\ServiceException;
use App\Mapper\Dashboard\TimetableRequestMapper;
use App\Service\Dashboard\Contracts\TimetableManagementServiceInterface;

class TimetableController extends AbstractDashboardController
{
    use HasStoreAction;
    use HasPublishedAction;
    use HasUpdateAction;
    use HasDeleteAction;
    use HasSingleData;

    public function __construct(
        private readonly TimetableManagementServiceInterface $service,
        private readonly TimetableRequestMapper              $timetableRequestMapper,
        ContextController                                    $contextController
    ) {
        parent::__construct($contextController);
    }

    public function indexAction(): void
    {
        $this->renderPage([
            'page' => 'timetable/index',
            'data' => $this->service->getAllTimetable(),
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function editAction(): void
    {
        /** @var TimetableDto $data */
        $data = $this->getSingleData();

        $this->renderPage([
            'page' => 'timetable/edit',
            'data' => $data,
            'locations' => $this->service->getAvailableLocations($data->locationId),
        ]);
    }

    /**
     * @throws ServiceException
     */
    public function createAction(): void
    {
        $this->renderPage([
            'page' => 'timetable/create',
            'locations' => $this->service->getAllActiveLocations(),
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function showAction(): void
    {
        $this->renderPage([
            'page' => 'timetable/show',
            'data' => $this->getSingleData(),
        ]);
    }

    /**
     * @throws NotFoundException
     */
    public function confirmDeleteAction(): void
    {
        $this->renderPage([
            'page' => 'timetable/delete',
            'data' => $this->getSingleData(),
        ]);
    }

    protected function getModuleName(): string
    {
        return 'timetable';
    }

    protected function getDataToCreate(): CreateTimetableDto
    {
        return $this->timetableRequestMapper->mapCreate();
    }

    protected function getDataToUpdate(): UpdateTimetableDto
    {
        return $this->timetableRequestMapper->mapUpdate();
    }

    protected function getDataToPublished(): PublishedDto
    {
        return $this->timetableRequestMapper->mapPublication();
    }

    protected function getDataToDelete(): ?int
    {
        return $this->timetableRequestMapper->mapDelete();
    }

    /**
     * @throws ServiceException
     */
    protected function handleCreate(DataTransferObjectInterface $data): void
    {
        /** @var CreateTimetableDto $data */
        try {
            $this->service->createTimetable($data);
        } catch (ServiceException $e) {
            if ($e->getCode() !== 409) {
                throw $e;
            }

            $oldInput = $this->request->getFormData();
            unset($oldInput['csrf_token']);

            $this->sessionManager->setFlash(
                type: 'warning',
                message: ['location_id' => $e->getMessage()],
                context: ['oldInput' => $oldInput],
            );

            $this->redirect(
                "{$this->contextController->config->getDashboardRoute()}/timetable/create"
            );
        }
    }

    /**
     * @throws ServiceException
     */
    protected function handleUpdate(DataTransferObjectInterface $data): void
    {

        try {
            /** @var UpdateTimetableDto $data */
            $this->service->updateTimetable($data);
        } catch (ServiceException $e) {
            if ($e->getCode() !== 409) {
                throw $e;
            }

            $oldInput = $this->request->getFormData();
            unset($oldInput['csrf_token']);

            $this->sessionManager->setFlash(
                type: 'warning',
                message: ['location_id' => $e->getMessage()],
                context: ['oldInput' => $oldInput],
            );

            $this->redirect(
                "{$this->contextController->config->getDashboardRoute()}/timetable/edit/{$data->id}"
            );
        }
    }

    protected function handleDelete(int $id): void
    {
        $shouldNotify = !empty($this->request->getFormParam('is_notify'));
        $this->service->deleteTimetable($id, $shouldNotify);
    }

    protected function handlePublish(DataTransferObjectInterface $data): void
    {
        /** @var PublishedDto $data */
        $this->service->publishedTimetable($data);
    }
}
