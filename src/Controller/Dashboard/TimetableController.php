<?php

namespace App\Controller\Dashboard;

use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Service\Dashboard\TimetableManagementServiceInterface;

class TimetableController extends AbstractDashboardController
{

  public function __construct(
    public TimetableManagementServiceInterface $timetableService,
    Request $request,
    EasyCSRF $easyCSRF
  ) {
    parent::__construct($request, $easyCSRF, $timetableService);
  }

  public function startAction(): void
  {
    $this->renderPage([
      'page' => 'timetable/index',
      'data' => $this->timetableService->getAllTimetable(),
    ]);
  }

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

  public function showAction(): void
  {
    $this->renderPage([
      'page' => 'timetable/show',
      'data' => $this->getSingleData(),
    ]);
  }

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

  protected function handleCreate(array $data): void
  {
    $this->timetableService->createTimetable($data);
  }

  protected function handleUpdate(array $data): void
  {
    $this->timetableService->updateTimetable($data);
  }

  protected function handleDelete(int $id): void
  {
    $this->timetableService->deleteTimetable($id);
  }

  protected function handlePublish(array $data): void
  {
    $this->timetableService->publishedTimetable($data);
  }

  protected function handleMove(array $data): void
  {
    $this->timetableService->moveTimetable($data);
  }
}
