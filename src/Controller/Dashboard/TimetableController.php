<?php

namespace App\Controller\Dashboard;

use App\Controller\Dashboard\Traits\HasDeleteAction;
use App\Controller\Dashboard\Traits\HasPublishedAction;
use App\Controller\Dashboard\Traits\HasSingleData;
use App\Controller\Dashboard\Traits\HasStoreAction;
use App\Controller\Dashboard\Traits\HasUpdateAction;
use App\Core\ContextController;
use App\DTO\Dashboard\PublishedDto;
use App\DTO\DataTransferObjectInterface;
use App\Exception\NotFoundException;
use App\Mapper\Dashboard\TimetableRequestMapper;
use App\Service\Dashboard\Contracts\TimetableManagementServiceInterface;

class TimetableController extends AbstractDashboardController
{
    use HasStoreAction, HasPublishedAction, HasUpdateAction, HasDeleteAction, HasSingleData;

    public function __construct(
        private readonly TimetableManagementServiceInterface $service,
        private readonly TimetableRequestMapper              $timetableRequestMapper,
        ContextController                                    $contextController
    )
    {
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
        $this->renderPage([
            'page' => 'timetable/edit',
            'data' => $this->getSingleData(),
        ]);
    }

    public function createAction(): void
    {
        $this->renderPage([
            'page' => 'timetable/create',
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

    protected function getDataToCreate(): DataTransferObjectInterface
    {
        return $this->timetableRequestMapper->mapCreate();
    }

    protected function getDataToUpdate(): DataTransferObjectInterface
    {
        return $this->timetableRequestMapper->mapUpdate();
    }

    protected function getDataToPublished(): PublishedDto
    {
        return $this->timetableRequestMapper->mapPublication();
    }

    protected function handleCreate(DataTransferObjectInterface $data): void
    {
        $this->service->createTimetable($data);
    }

    protected function handleUpdate(DataTransferObjectInterface $data): void
    {
        $this->service->updateTimetable($data);
    }

    protected function handleDelete(int $id): void
    {
        $shouldNotify = !empty($this->request->getFormParam('is_notify'));
        $this->service->deleteTimetable($id, $shouldNotify);
    }

    protected function handlePublish(DataTransferObjectInterface $data): void
    {
        $this->service->publishedTimetable($data);
    }
}
