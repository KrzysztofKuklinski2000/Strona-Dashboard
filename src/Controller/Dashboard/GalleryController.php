<?php

namespace App\Controller\Dashboard;

use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Service\Dashboard\GalleryManagementServiceInterface;

class GalleryController extends AbstractDashboardController {

  public function __construct(
    public GalleryManagementServiceInterface $galleryService,
    Request $request,
    EasyCSRF $easyCSRF
  ) {
    parent::__construct($request, $easyCSRF, $galleryService);
  }

  public function indexAction(): void {
    $this->renderPage([
      'page' => 'gallery/index',
      'data' => $this->galleryService->getAllGallery(),
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
    $this->galleryService->createGallery($data);
  }

  protected function handleUpdate(array $data): void {
    $this->galleryService->updateGallery($data);
  }

  protected function handleDelete(int $id): void {
    $this->galleryService->deleteGallery($id);
  }

  protected function handlePublish(array $data): void {
    $this->galleryService->publishedGallery($data);
  }

  protected function handleMove(array $data): void {
    $this->galleryService->moveGallery($data);
  }
}
