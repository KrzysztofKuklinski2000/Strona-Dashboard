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
use App\DTO\Notification\NotificationReportDto;
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
        $data = $this->service->getAllTimetable();

        $notificationReport = $this->sessionManager->get('timetable_notification_report');

        $this->sessionManager->remove('timetable_notification_report');

        $this->renderPage([
            'page' => 'timetable/index',
            'data' => $data,
            'notification_report' => $notificationReport,
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
            $report = $this->service->createTimetable($data);
            $this->storeNotificationReport($report);
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
            $report = $this->service->updateTimetable($data);
            $this->storeNotificationReport($report);
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
        $report = $this->service->deleteTimetable($id, $shouldNotify);
        $this->storeNotificationReport($report);
    }

    protected function handlePublish(DataTransferObjectInterface $data): void
    {
        /** @var PublishedDto $data */
        $report = $this->service->publishedTimetable($data);
        $this->storeNotificationReport($report);
    }


    private function storeNotificationReport(
        ?NotificationReportDto $report,
    ): void {
        if ($report === null) {
            $this->sessionManager->remove('timetable_notification_report');
            return;
        }

        $this->sessionManager->set(
            'timetable_notification_report',
            [
                'sent_count' => $report->sentCount,
                'failed_recipients' => $report->failedRecipients,
                'recipients_loaded' => $report->recipientsLoaded,
            ],
        );
    }
}
