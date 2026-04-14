<?php

namespace App\Controller\Dashboard;

use App\Controller\Dashboard\Traits\HasDeleteAction;
use App\Controller\Dashboard\Traits\HasPublishedAction;
use App\Controller\Dashboard\Traits\HasStoreAction;
use App\Controller\Dashboard\Traits\HasUpdateAction;
use App\Core\Request;
use App\Exception\NotFoundException;
use App\Middleware\CsrfMiddleware;
use App\Service\Dashboard\TimetableManagementServiceInterface;
use App\View;

class TimetableController extends AbstractDashboardController
{
    use HasStoreAction, HasPublishedAction, HasUpdateAction, HasDeleteAction;

    public function __construct(
        private readonly TimetableManagementServiceInterface $service,
        Request                                              $request,
        View                                                 $view,
        CsrfMiddleware                                       $csrfMiddleware
    )
    {
        parent::__construct($request, $service, $view, $csrfMiddleware);
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

    protected function getDataToCreate(): array
    {
        return $this->getDataToAddTimetable();
    }

    protected function getDataToUpdate(): array
    {
        return $this->getDataToEditTimetable();
    }

    protected function getDataToPublished(): array
    {
        return $this->getDataToPublishedTimetable();
    }

    protected function handleCreate(array $data): void
    {
        $this->service->createTimetable($data);
    }

    protected function handleUpdate(array $data): void
    {
        $this->service->updateTimetable($data);
    }

    protected function handleDelete(int $id): void
    {
        $shouldNotify = !empty($this->request->getFormParam('is_notify'));
        $this->service->deleteTimetable($id, $shouldNotify);
    }

    protected function handlePublish(array $data): void
    {
        $this->service->publishedTimetable($data);
    }
}
