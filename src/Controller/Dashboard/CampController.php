<?php

namespace App\Controller\Dashboard;

use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Service\Dashboard\CampManagementServiceInterface;

class CampController extends AbstractDashboardController
{
  public function __construct(
    public CampManagementServiceInterface $campService,
    Request $request,
    EasyCSRF $easyCSRF
  ) {
    parent::__construct($request, $easyCSRF, $campService);
  }

  protected function getModuleName(): string
  {
    return 'camp';
  }

  public function startAction(): void
  {
    $this->redirect('/?dashboard=camp&action=edit');
  }

  public function editAction(): void
  {
    $this->renderPage([
      'page' => 'camp/edit',
      'data' => $this->campService->getCamp(),
    ]);
  }

  protected function getDataToUpdate(): array
  {
    return $this->getDataToCampEdit();
  }

  protected function handleUpdate(array $data): void
  {
    $this->campService->updateCamp($data);
  }
}
