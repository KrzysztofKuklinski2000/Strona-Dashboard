<?php

namespace App\Controller\Dashboard;

use App\View;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Middleware\CsrfMiddleware;
use App\Service\Dashboard\CampManagementServiceInterface;

class CampController extends AbstractDashboardController {
  public function __construct(
    public CampManagementServiceInterface $service,
    Request $request,
    EasyCSRF $easyCSRF,
    View $view,
    CsrfMiddleware $csrfMiddleware
  ) {
    parent::__construct($request, $easyCSRF, $service, $view, $csrfMiddleware);
  }

  public function editAction(): void {
    $this->renderPage([
      'page' => 'camp/edit',
      'data' => $this->service->getCamp(),
    ]);
  }

  protected function getModuleName(): string {
    return 'camp';
  }

  protected function getDataToUpdate(): array {
    return $this->getDataToCampEdit();
  }

  protected function handleUpdate(array $data): void {
    $this->service->updateCamp($data);
  }
}
