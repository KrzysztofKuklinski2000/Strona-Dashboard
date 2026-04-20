<?php

namespace App\Controller\Dashboard;

use App\Controller\Dashboard\Traits\HasUpdateAction;
use App\View;
use App\Core\Request;
use App\Middleware\CsrfMiddleware;
use App\Service\Dashboard\ContactManagementServiceInterface;

class ContactController extends AbstractDashboardController
{
    use HasUpdateAction;
    public function __construct(
        public ContactManagementServiceInterface $service,
        Request                                  $request,
        View                                     $view,
        CsrfMiddleware                           $csrfMiddleware
    )
    {
        parent::__construct($request, $service, $view, $csrfMiddleware);
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
