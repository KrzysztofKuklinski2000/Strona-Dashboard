<?php

namespace App\Controller\Dashboard;

use App\Controller\Dashboard\Traits\HasDeleteAction;
use App\Controller\Dashboard\Traits\HasMoveAction;
use App\Controller\Dashboard\Traits\HasPublishedAction;
use App\Controller\Dashboard\Traits\HasStoreAction;
use App\Controller\Dashboard\Traits\HasUpdateAction;
use App\View;
use App\Core\Request;
use App\Middleware\CsrfMiddleware;
use App\Service\Dashboard\GalleryManagementServiceInterface;

class GalleryController extends AbstractDashboardController {
    use HasStoreAction, HasDeleteAction, HasUpdateAction, HasPublishedAction, HasMoveAction;

  public function __construct(
    public GalleryManagementServiceInterface $service,
    Request $request,
    View $view,
    CsrfMiddleware $csrfMiddleware
  ) {
    parent::__construct($request, $service, $view, $csrfMiddleware);
  }

  public function indexAction(): void {
    $this->renderPage([
      'page' => 'gallery/index',
      'data' => $this->service->getAllGallery(),
    ]);
  }

  public function editAction(): void {
    $this->renderPage([
      'page' => 'gallery/edit',
      'data' => $this->getSingleData(),
    ]);
  }

  public function createAction(): void {
    $this->renderPage([
      'page' => 'gallery/create',
    ]);
  }

  public function showAction(): void {
    $this->renderPage([
      'page' => 'gallery/show',
      'data' => $this->getSingleData(),
    ]);
  }

  public function confirmDeleteAction(): void {
    $this->renderPage([
      'page' => 'gallery/delete',
      'data' => $this->getSingleData(),
    ]);
  }

  protected function getModuleName(): string {
    return 'gallery';
  }

  protected function getDataToCreate(): array {
    return $this->getDataToAddImage();
  }

  protected function getDataToUpdate(): array{
    return $this->getDataToEditImage();
  }
  

  protected function handleCreate(array $data): void {
    $this->service->createGallery($data);
  }

  protected function handleUpdate(array $data): void {
    $this->service->updateGallery($data);
  }

  protected function handleDelete(int $id): void {
    $this->service->deleteGallery($id);
  }

  protected function handlePublish(array $data): void {
    $this->service->publishedGallery($data);
  }

  protected function handleMove(array $data): void {
    $this->service->moveGallery($data);
  }
}
