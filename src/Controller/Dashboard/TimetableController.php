<?php

namespace App\Controller\Dashboard;

use App\Core\Request;
use App\Middleware\CsrfMiddleware;
use App\Service\Dashboard\TimetableManagementServiceInterface;
use App\View;
use EasyCSRF\EasyCSRF;

class TimetableController extends AbstractDashboardController {

  public function __construct(
    private TimetableManagementServiceInterface $service,
    Request $request,
    EasyCSRF $easyCSRF,
    View $view,
    CsrfMiddleware $csrfMiddleware
  ) {
    parent::__construct($request, $easyCSRF, $service, $view, $csrfMiddleware);
  }

  public function indexAction(): void {
    $this->renderPage([
      'page' => 'timetable/index',
      'data' => $this->service->getAllTimetable(),
    ]);
  }

  public function editAction(): void {
    $this->renderPage([
      'page' => 'timetable/edit',
      'data' => $this->getSingleData(),
    ]);
  }

  public function createAction(): void {
    $this->renderPage([
      'page' => 'timetable/create',
    ]);
  }

  public function showAction(): void {
    $this->renderPage([
      'page' => 'timetable/show',
      'data' => $this->getSingleData(),
    ]);
  }

  public function confirmDeleteAction(): void {
    $this->renderPage([
      'page' => 'timetable/delete',
      'data' => $this->getSingleData(),
    ]);
  }

  protected function getModuleName(): string {
    return 'timetable';
  }

  protected function getDataToCreate(): array {
    return $this->getDataToAddTimetable();
  }

  protected function getDataToUpdate(): array {
    return $this->getDataToEditTimetable();
  }

  protected function handleCreate(array $data): void {
    $this->service->createTimetable($data);
  }

  protected function handleUpdate(array $data): void {
    $this->service->updateTimetable($data);
  }

  protected function handleDelete(int $id): void {
    $this->service->deleteTimetable($id);
  }

  protected function handlePublish(array $data): void {
    $this->service->publishedTimetable($data);
  }

  protected function handleMove(array $data): void {
    $this->service->moveTimetable($data);
  }
}
