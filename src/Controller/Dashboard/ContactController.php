<?php

namespace App\Controller\Dashboard;

use App\View;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Core\ActionResolver;
use App\Service\Dashboard\ContactManagementServiceInterface;

class ContactController extends AbstractDashboardController {
  public function __construct(
    public ContactManagementServiceInterface $contactService,
    Request $request,
    EasyCSRF $easyCSRF,
    View $view,
    ActionResolver $actionResolver
  ) {
    parent::__construct($request, $easyCSRF, $contactService, $view, $actionResolver);
  }

  protected function getModuleName(): string
  {
    return 'contact';
  }

  public function indexAction(): void
  {
    $this->redirect('/?dashboard=contact&action=edit');
  }

  public function editAction(): void
  {
    $this->renderPage([
      'page' => 'contact/edit',
      'data' => $this->contactService->getContact(),
    ]);
  }

  protected function getDataToUpdate(): array
  {
    return $this->getDataToContactEdit();
  }

  protected function handleUpdate(array $data): void
  {
    $this->contactService->updateContact($data);
  }
}
