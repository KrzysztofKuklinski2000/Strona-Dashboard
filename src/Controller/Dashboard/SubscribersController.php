<?php

namespace App\Controller\Dashboard;

use App\Core\Request;
use App\View;
use App\Middleware\CsrfMiddleware;
use App\Service\Dashboard\SubscribersManagementServiceInterface;

class SubscribersController extends AbstractDashboardController
{
    public function __construct(
        private SubscribersManagementServiceInterface $service,
        Request $request,
        View $view,
        CsrfMiddleware $csrfMiddleware
    ) {

        parent::__construct($request, $service, $view, $csrfMiddleware);
    }

    public function indexAction(): void
    {
        $this->renderPage([
          'page' => 'subscribers/index',
          'data' => $this->service->getAllSubscribers(),
        ]);
    }

    public function createAction(): void
    {
        $this->renderPage([
          'page' => 'subscribers/create'
        ]);
    }

    public function editAction(): void {
        $this->renderPage([
        'page' => 'subscribers/edit',
        'data' => $this->getSingleData(),
        ]);
    }

    public function showAction(): void {
        $this->renderPage([
        'page' => 'subscribers/show',
        'data' => $this->getSingleData(),
        ]);
    }

    public function confirmDeleteAction(): void {
        $this->renderPage([
        'page' => 'subscribers/delete',
        'data' => $this->getSingleData(),
        ]);
    }

    protected function getModuleName(): string
    {
        return 'subscribers';
    }

    protected function getDataToCreate(): array {
        return $this->getEmailToCreate();
    }

    protected function getDataToUpdate(): array {
        return $this->getEmailToUpdate();
    }

    protected function handleCreate(array $data): void
    {
        $this->service->createSubscriber($data);
    }

    protected function handleUpdate(array $data): void {
        $this->service->updateSubscriber($data);
    }

    protected function handleDelete(int $id): void{
        $this->service->deleteSubscriber($id);
    }
}

