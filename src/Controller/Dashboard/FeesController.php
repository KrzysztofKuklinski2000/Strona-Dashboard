<?php

namespace App\Controller\Dashboard;

use App\View;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Core\ActionResolver;
use App\Service\Dashboard\FeesManagementServiceInterface;

class FeesController extends AbstractDashboardController {
  public function __construct(
    public FeesManagementServiceInterface $feesService,
    Request $request,
    EasyCSRF $easyCSRF,
    View $view,
    ActionResolver $actionResolver
  ) {
    parent::__construct($request, $easyCSRF, $feesService, $view, $actionResolver);
  }

  public function indexAction(): void {
    $this->redirect('/?dashboard=fees&action=edit');
  }

  public function editAction(): void {
    $this->renderPage([
      'page' => 'fees/edit',
      'data' => $this->feesService->getFees(),
    ]);
  }

  protected function getModuleName(): string {
    return 'fees';
  }

  protected function getDataToUpdate(): array {
    return $this->getDataToFeesEdit();
  }

  protected function handleUpdate(array $data): void {
    $this->feesService->updateFees($data);
  }
}
