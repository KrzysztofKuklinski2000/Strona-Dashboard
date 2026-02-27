<?php

namespace App\Controller\Dashboard;

use App\View;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Middleware\CsrfMiddleware;
use App\Service\Dashboard\StartManagementServiceInterface;

class StartController extends AbstractDashboardController {

  public function __construct(
    public StartManagementServiceInterface $service,
    Request $request,
    EasyCSRF $easyCSRF,
    View $view,
    CsrfMiddleware $csrfMiddleware
  ) {
    parent::__construct($request, $easyCSRF, $service, $view, $csrfMiddleware);
  }

  public function indexAction(): void {
    $this->renderPage([
      'page' => 'start/index',
      'data' => $this->service->getAllMain(),
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
    $this->service->createMain($data);
  }

  protected function handleUpdate(array $data): void {
    $this->service->updateMain($data);
  }

  protected function handleDelete(int $id): void {
    $this->service->deleteMain($id);
  }

  protected function handlePublish(array $data): void {
    $this->service->publishedMain($data);
  }

  protected function handleMove(array $data): void {
    $this->service->moveMain($data);
  }
}
