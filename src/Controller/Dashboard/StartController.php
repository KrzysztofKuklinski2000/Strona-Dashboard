<?php

namespace App\Controller\Dashboard;

use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Service\Dashboard\StartManagementServiceInterface;

class StartController extends AbstractDashboardController {

  public function __construct(
    public StartManagementServiceInterface $startService,
    Request $request,
    EasyCSRF $easyCSRF
  ) {
    parent::__construct($request, $easyCSRF, $startService);
  }

  public function indexAction(): void {
    $this->renderPage([
      'page' => 'start/index',
      'data' => $this->startService->getAllMain(),
    ]);
  }

  public function editAction(): void {
    $this->renderPage([
      'page' => 'start/edit',
      'data' => $this->getSingleData(),
    ]);
  }

  public function createAction(): void {
    $this->renderPage([
      'page' => 'start/create',
    ]);
  }

  public function showAction(): void {
    $this->renderPage([
      'page' => 'start/show',
      'data' => $this->getSingleData(),
    ]);
  }

  public function confirmDeleteAction(): void {
    $this->renderPage([
      'page' => 'start/delete',
      'data' => $this->getSingleData(),
    ]);
  }

  protected function getModuleName(): string {
    return 'start';
  }

  protected function getTableName(): string {
    return 'main_page_posts';
  }
  
  protected function getDataToCreate(): array{
    return $this->getPostDataToCreate();
  }

  protected function getDataToUpdate(): array{
    return $this->getPostDataToEdit();
  }
  

  protected function handleCreate(array $data): void {
    $this->startService->createMain($data);
  }

  protected function handleUpdate(array $data): void {
    $this->startService->updateMain($data);
  }

  protected function handleDelete(int $id): void {
    $this->startService->deleteMain($id);
  }

  protected function handlePublish(array $data): void {
    $this->startService->publishedMain($data);
  }

  protected function handleMove(array $data): void {
    $this->startService->moveMain($data);
  }
}
