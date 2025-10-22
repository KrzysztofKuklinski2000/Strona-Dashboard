<?php

namespace App\Controller\Dashboard;

use App\View;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Core\ActionResolver;
use App\Service\Dashboard\ImportantPostsManagementServiceInterface;

class ImportantPostsController extends AbstractDashboardController {
  public function __construct(
    public ImportantPostsManagementServiceInterface $importantPostsService,
    Request $request,
    EasyCSRF $easyCSRF,
    View $view,
    ActionResolver $actionResolver
  ) {
    parent::__construct($request, $easyCSRF, $importantPostsService, $view, $actionResolver);
  }

  public function indexAction(): void {
    $this->renderPage([
      'page' => 'important_posts/index',
      'data' => $this->importantPostsService->getAllImportantPosts(),
    ]);
  }

  public function editAction(): void {
    $this->renderPage([
      'page' => 'important_posts/edit',
      'data' => $this->getSingleData(),
    ]);
  }

  public function createAction(): void {
    $this->renderPage([
      'page' => 'important_posts/create',
    ]);
  }

  public function showAction(): void {
    $this->renderPage([
      'page' => 'important_posts/show',
      'data' => $this->getSingleData(),
    ]);
  }

  public function confirmDeleteAction(): void {
    $this->renderPage([
      'page' => 'important_posts/delete',
      'data' => $this->getSingleData(),
    ]);
  }

  protected function getModuleName(): string {
    return 'important_posts';
  }

  protected function getDataToCreate(): array {
    return $this->getPostDataToCreate();
  }

  protected function getDataToUpdate(): array {
    return $this->getPostDataToEdit();
  }

  protected function handleCreate(array $data): void {
    $this->importantPostsService->createImportantPost($data);
  }

  protected function handleUpdate(array $data): void {
    $this->importantPostsService->updateImportantPost($data);
  }

  protected function handleDelete(int $id): void {
    $this->importantPostsService->deleteImportantPost($id);
  }

  protected function handlePublish(array $data): void {
    $this->importantPostsService->publishedImportantPost($data);
  }

  protected function handleMove(array $data): void {
    $this->importantPostsService->moveImportantPost($data);
  }
}
