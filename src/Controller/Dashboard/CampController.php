<?php

namespace App\Controller\Dashboard;

use App\View;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Core\ActionResolver;
use App\Middleware\CsrfMiddleware;
use App\Service\Dashboard\CampManagementServiceInterface;

class CampController extends AbstractDashboardController {
  public function __construct(
    public CampManagementServiceInterface $campService,
    Request $request,
    EasyCSRF $easyCSRF,
    View $view,
    ActionResolver $actionResolver,
    CsrfMiddleware $csrfMiddleware
  ) {
    parent::__construct($request, $easyCSRF, $campService, $view, $actionResolver, $csrfMiddleware);
  }

  public function indexAction(): void {
    $this->redirect('/?dashboard=camp&action=edit');
  }

  public function editAction(): void {
    $this->renderPage([
      'page' => 'camp/edit',
      'data' => $this->campService->getCamp(),
    ]);
  }

  protected function getModuleName(): string {
    return 'camp';
  }

  protected function getDataToUpdate(): array {
    return $this->getDataToCampEdit();
  }

  protected function handleUpdate(array $data): void {
    $this->campService->updateCamp($data);
  }
}
