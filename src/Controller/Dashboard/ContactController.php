<?php

namespace App\Controller\Dashboard;

use App\View;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Middleware\CsrfMiddleware;
use App\Service\Dashboard\ContactManagementServiceInterface;

class ContactController extends AbstractDashboardController {
  public function __construct(
    public ContactManagementServiceInterface $service,
    Request $request,
    EasyCSRF $easyCSRF,
    View $view,
    CsrfMiddleware $csrfMiddleware
  ) {
    parent::__construct($request, $easyCSRF, $service, $view, $csrfMiddleware);
  }

  protected function getModuleName(): string
  {
    return 'contact';
  }

  public function editAction(): void
  {
    $this->renderPage([
      'page' => 'contact/edit',
      'data' => $this->service->getContact(),
    ]);
  }

  protected function getDataToUpdate(): array
  {
    return $this->getDataToContactEdit();
  }

  protected function handleUpdate(array $data): void
  {
    $this->service->updateContact($data);
  }
}
