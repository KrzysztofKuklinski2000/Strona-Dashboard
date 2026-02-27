<?php

namespace App\Controller\Dashboard;

use App\View;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Middleware\CsrfMiddleware;
use App\Service\Dashboard\FeesManagementServiceInterface;

class FeesController extends AbstractDashboardController {
  public function __construct(
    public FeesManagementServiceInterface $service,
    Request $request,
    EasyCSRF $easyCSRF,
    View $view,
    CsrfMiddleware $csrfMiddleware
  ) {
    parent::__construct($request, $easyCSRF, $service, $view, $csrfMiddleware);
  }

  public function editAction(): void {
    $this->renderPage([
      'page' => 'fees/edit',
      'data' => $this->service->getFees(),
    ]);
  }

  protected function getModuleName(): string {
    return 'fees';
  }

  protected function getDataToUpdate(): array {
    return $this->getDataToFeesEdit();
  }

  protected function handleUpdate(array $data): void {
    $this->service->updateFees($data);
  }
}
