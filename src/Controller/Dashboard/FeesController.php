<?php

namespace App\Controller\Dashboard;

use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Service\Dashboard\FeesManagementServiceInterface;

class FeesController extends AbstractDashboardController {
  public function __construct(
    public FeesManagementServiceInterface $feesService,
    Request $request,
    EasyCSRF $easyCSRF
  ) {
    parent::__construct($request, $easyCSRF, $feesService);
  }

  protected function getModuleName(): string {
    return 'fees';
  }

  public function startAction(): void {
    $this->redirect('/?dashboard=fees&action=edit');
  }

  public function editAction(): void {
    $this->renderPage([
      'page' => 'fees/edit',
      'data' => $this->feesService->getFees(),
    ]);
  }

  protected function getDataToUpdate(): array
  {
    return $this->getDataToFeesEdit();
  }

  protected function handleUpdate(array $data): void
  {
    $this->feesService->updateFees($data);
  }
}
